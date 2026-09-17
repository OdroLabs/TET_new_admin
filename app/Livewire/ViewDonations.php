<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Donation;

class ViewDonations extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $methodFilter = 'all';

    public function updateStatus($id, $status)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = $status;
        $donation->save();
        session()->flash('message', "Donation {$donation->reference} marked as {$status}!");
    }

    public function deleteDonation($id)
    {
        Donation::findOrFail($id)->delete();
        session()->flash('message', 'Donation record deleted.');
    }

    public function render()
    {
        $query = Donation::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('donor_name', 'like', '%' . $this->search . '%')
                  ->orWhere('donor_email', 'like', '%' . $this->search . '%')
                  ->orWhere('reference', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->methodFilter !== 'all') {
            $query->where('payment_method', $this->methodFilter);
        }

        $donations = $query->latest()->paginate(15);

        // KPI Summary
        $totalRaised = Donation::where('status', 'verified')->sum('amount');
        $pendingCount = Donation::where('status', 'pending')->count();
        $totalDonors = Donation::count();

        return view('livewire.view-donations', [
            'donations' => $donations,
            'totalRaised' => $totalRaised,
            'pendingCount' => $pendingCount,
            'totalDonors' => $totalDonors,
        ])->layout('components.layouts.admin');
    }
}