<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EnterpriseInquiry;

class ManageOrders extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = 'all';
    public $statusFilter = 'all';

    // ✅ CRUCIAL FIX: Reset pagination when filters or search change
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updateStatus($id, $status)
    {
        // Guard against invalid status values
        if (!in_array($status, ['new', 'contacted', 'completed'])) {
            return;
        }

        $inquiry = EnterpriseInquiry::findOrFail($id);
        $inquiry->status = $status;
        $inquiry->save();

        session()->flash('message', "Order {$inquiry->reference} marked as {$status}.");
    }

    public function deleteInquiry($id)
    {
        EnterpriseInquiry::findOrFail($id)->delete();
        session()->flash('message', 'Inquiry record removed.');
    }

    public function render()
    {
        $query = EnterpriseInquiry::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('customer_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                  ->orWhere('reference', 'like', '%' . $this->search . '%')
                  ->orWhere('item_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $inquiries = $query->latest()->paginate(15);

        // Stats
        $newCount = EnterpriseInquiry::where('status', 'new')->count();
        $productOrders = EnterpriseInquiry::where('type', 'product_order')->count();
        $hallBookings = EnterpriseInquiry::where('type', 'hall_booking')->count();

        return view('livewire.manage-orders', [
            'inquiries' => $inquiries,
            'newCount' => $newCount,
            'productOrders' => $productOrders,
            'hallBookings' => $hallBookings,
        ])->layout('components.layouts.admin');
    }
}