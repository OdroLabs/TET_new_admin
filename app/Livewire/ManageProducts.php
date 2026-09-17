<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;

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
                'en' => $prod->getTranslation('title', 'en') ?: '',
                'si' => $prod->getTranslation('title', 'si') ?: '',
                'ta' => $prod->getTranslation('title', 'ta') ?: '',
            ],
            'description' => [
                'en' => $prod->getTranslation('description', 'en') ?: '',
                'si' => $prod->getTranslation('description', 'si') ?: '',
                'ta' => $prod->getTranslation('description', 'ta') ?: '',
            ],
            'price' => $prod->price,
            'currency' => $prod->currency,
            'specs' => $prod->specs,
            'badge' => $prod->badge,
            'icon' => $prod->icon,
            'is_available' => $prod->is_available,
        ];
        $this->existingImage = $prod->image;
        $this->productImage = null;
    }

    public function saveProduct()
    {
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
        $prod->currency = $this->productState['currency'];
        $prod->specs = $this->productState['specs'];
        $prod->badge = $this->productState['badge'];
        $prod->icon = $this->productState['icon'];
        $prod->is_available = $this->productState['is_available'];

        if ($this->productImage) {
            $prod->image = $this->productImage->store('products', 'public');
        }

        $prod->save();
        $this->editingId = null;
        $this->productImage = null;

        session()->flash('message', 'Product catalog updated successfully!');
    }

    public function toggleAvailability($id)
    {
        $prod = Product::findOrFail($id);
        $prod->is_available = !$prod->is_available;
        $prod->save();
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted from catalog.');
    }

    public function render()
    {
        return view('livewire.manage-products')->layout('components.layouts.admin');
    }
}