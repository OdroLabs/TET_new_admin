<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ManageProducts extends Component
{
    use WithFileUploads;

    public $editingId = null;
    public $productState = [
        'title' => ['en' => '', 'si' => '', 'ta' => ''],
        'description' => ['en' => '', 'si' => '', 'ta' => ''],
        'price' => 450,
        'currency' => 'LKR',
        'specs' => '',
        'badge' => '',
        'icon' => '🛡️',
        'is_available' => true,
    ];
    public $productImage;
    public $existingImage;

    public function getProductsProperty()
    {
        return Product::orderBy('order', 'asc')->get();
    }

    public function newProduct()
    {
        $this->editingId = 'new';
        $this->productState = [
            'title' => ['en' => '', 'si' => '', 'ta' => ''],
            'description' => ['en' => '', 'si' => '', 'ta' => ''],
            'price' => 450,
            'currency' => 'LKR',
            'specs' => 'Pack of 12',
            'badge' => 'New',
            'icon' => '🛡️',
            'is_available' => true,
        ];
        $this->productImage = null;
        $this->existingImage = null;
    }

    public function editProduct($id)
    {
        $prod = Product::findOrFail($id);
        $this->editingId = $id;
        $this->productState = [
            'title' => [
                'en' => $prod->getTranslation('title', 'en', false) ?: '',
                'si' => $prod->getTranslation('title', 'si', false) ?: '',
                'ta' => $prod->getTranslation('title', 'ta', false) ?: '',
            ],
            'description' => [
                'en' => $prod->getTranslation('description', 'en', false) ?: '',
                'si' => $prod->getTranslation('description', 'si', false) ?: '',
                'ta' => $prod->getTranslation('description', 'ta', false) ?: '',
            ],
            'price' => $prod->price,
            'currency' => $prod->currency,
            'specs' => $prod->specs,
            'badge' => $prod->badge,
            'icon' => $prod->icon,
            'is_available' => (bool) $prod->is_available,
        ];
        $this->existingImage = $prod->image;
        $this->productImage = null;
    }

    public function saveProduct()
    {
        // Validation
        $this->validate([
            'productState.title.en' => 'required|string|max:255',
            'productState.price' => 'required|numeric|min:0',
            'productImage' => 'nullable|image|max:10240',
        ]);

        if ($this->editingId === 'new') {
            $prod = new Product();
            $prod->order = (Product::max('order') ?? 0) + 1;
        } else {
            $prod = Product::findOrFail($this->editingId);
        }

        foreach (['title', 'description'] as $field) {
            foreach ($this->productState[$field] as $lang => $val) {
                $prod->setTranslation($field, $lang, $val ?? '');
            }
        }

        $prod->price = $this->productState['price'];
        $prod->currency = $this->productState['currency'] ?: 'LKR';
        $prod->specs = $this->productState['specs'];
        $prod->badge = $this->productState['badge'];
        $prod->icon = $this->productState['icon'] ?: '🛡️';
        $prod->is_available = (bool) $this->productState['is_available'];

        if ($this->productImage) {
            // Delete old file if updating
            if ($prod->image && Storage::disk('public')->exists($prod->image)) {
                Storage::disk('public')->delete($prod->image);
            }
            $prod->image = $this->productImage->store('products', 'public');
        }

        $prod->save();

        // ✅ CRUCIAL FIX: Invalidate cache so frontend gets fresh data
        Cache::forget('api_products_list');

        $this->editingId = null;
        $this->productImage = null;
        $this->existingImage = null;

        session()->flash('message', 'Product catalog updated successfully!');
        $this->dispatch('reload-frontend-collection');
    }

    public function toggleAvailability($id)
    {
        $prod = Product::findOrFail($id);
        $prod->is_available = !$prod->is_available;
        $prod->save();

        // ✅ CRUCIAL FIX: Clear cache on status toggle
        Cache::forget('api_products_list');

        $this->dispatch('reload-frontend-collection');
    }

    public function deleteProduct($id)
    {
        $prod = Product::findOrFail($id);
        if ($prod->image && Storage::disk('public')->exists($prod->image)) {
            Storage::disk('public')->delete($prod->image);
        }
        $prod->delete();

        // ✅ CRUCIAL FIX: Clear cache on delete
        Cache::forget('api_products_list');

        session()->flash('message', 'Product deleted from catalog.');
        $this->dispatch('reload-frontend-collection');
    }

    public function render()
    {
        return view('livewire.manage-products')->layout('components.layouts.admin');
    }
}