<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactMessage;

class ViewContactMessages extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public function updateStatus($id, $status)
    {
        $msg = ContactMessage::findOrFail($id);
        $msg->status = $status;
        $msg->save();
        session()->flash('message', "Message {$msg->reference} marked as {$status}!");
    }

    public function deleteMessage($id)
    {
        ContactMessage::findOrFail($id)->delete();
        session()->flash('message', 'Message record deleted.');
    }

    public function render()
    {
        $query = ContactMessage::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('reference', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $messages = $query->latest()->paginate(15);
        $unreadCount = ContactMessage::where('status', 'unread')->count();

        return view('livewire.view-contact-messages', [
            'messages' => $messages,
            'unreadCount' => $unreadCount,
        ])->layout('components.layouts.admin');
    }
}