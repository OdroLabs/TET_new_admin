<?php

namespace App\Livewire;

use App\Models\MailSetting;
use App\Services\NotificationMailer;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Throwable;

class ManageMailSettings extends Component
{
    public bool $isEnabled = false;
    public string $host = '';
    public $port = 587;
    public string $encryption = 'tls';
    public string $username = '';
    public string $password = '';          // never pre-filled; blank = keep current
    public bool $hasPassword = false;
    public string $fromAddress = '';
    public string $fromName = '';

    public array $to = [];
    public array $cc = [];
    public string $newTo = '';
    public string $newCc = '';

    public bool $notifyContact = true;
    public bool $notifyInquiries = true;
    public bool $notifyDonations = true;

    public ?string $testResult = null;
    public bool $testOk = false;

    public function mount()
    {
        $s = MailSetting::current();
        $this->isEnabled = (bool) $s->is_enabled;
        $this->host = $s->host ?? '';
        $this->port = $s->port ?: 587;
        $this->encryption = $s->encryption ?: 'tls';
        $this->username = $s->username ?? '';
        $this->hasPassword = filled($s->password);
        $this->fromAddress = $s->from_address ?? '';
        $this->fromName = $s->from_name ?? '';
        $this->to = array_values($s->to_addresses ?? []);
        $this->cc = array_values($s->cc_addresses ?? []);
        $this->notifyContact = (bool) $s->notify_contact;
        $this->notifyInquiries = (bool) $s->notify_inquiries;
        $this->notifyDonations = (bool) $s->notify_donations;
    }

    /** Accepts one address or several separated by commas/semicolons/spaces. */
    private function addAddresses(string $list, string $input): void
    {
        $emails = preg_split('/[\s,;]+/', trim($this->{$input}), -1, PREG_SPLIT_NO_EMPTY);
        if (!$emails) return;

        foreach ($emails as $email) {
            if (Validator::make(['e' => $email], ['e' => 'email'])->fails()) {
                $this->addError($input, "“{$email}” is not a valid email address.");
                return;
            }
        }

        $current = array_map('strtolower', $this->{$list});
        foreach ($emails as $email) {
            if (!in_array(strtolower($email), $current, true)) {
                $this->{$list}[] = $email;
                $current[] = strtolower($email);
            }
        }
        $this->{$input} = '';
        $this->resetErrorBag($input);
    }

    public function addTo()  { $this->addAddresses('to', 'newTo'); }
    public function addCc()  { $this->addAddresses('cc', 'newCc'); }

    public function removeTo(int $i)
    {
        unset($this->to[$i]);
        $this->to = array_values($this->to);
    }

    public function removeCc(int $i)
    {
        unset($this->cc[$i]);
        $this->cc = array_values($this->cc);
    }

    public function clearPassword()
    {
        $this->password = '';
        $this->hasPassword = false;
    }

    private function settingRules(): array
    {
        $required = $this->isEnabled ? 'required' : 'nullable';
        return [
            'host' => "{$required}|string|max:255",
            'port' => 'required|integer|min:1|max:65535',
            'encryption' => 'required|in:tls,ssl,none',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:500',
            'fromAddress' => "{$required}|email|max:255",
            'fromName' => 'nullable|string|max:255',
            'to' => $this->isEnabled ? 'array|min:1' : 'array',
            'to.*' => 'email',
            'cc' => 'array',
            'cc.*' => 'email',
        ];
    }

    private function settingMessages(): array
    {
        return [
            'to.min' => 'Add at least one “To” recipient before enabling notifications.',
            'host.required' => 'SMTP host is required when notifications are enabled.',
            'fromAddress.required' => 'A “From” address is required when notifications are enabled.',
        ];
    }

    private function persist(): MailSetting
    {
        // Pick up anything typed but not yet added with the "+ Add" button
        if (trim($this->newTo) !== '') $this->addTo();
        if (trim($this->newCc) !== '') $this->addCc();

        $this->validate($this->settingRules(), $this->settingMessages());

        $s = MailSetting::current();
        $s->fill([
            'is_enabled' => $this->isEnabled,
            'host' => trim($this->host) ?: null,
            'port' => (int) $this->port,
            'encryption' => $this->encryption,
            'username' => trim($this->username) ?: null,
            'from_address' => trim($this->fromAddress) ?: null,
            'from_name' => trim($this->fromName) ?: null,
            'to_addresses' => array_values($this->to),
            'cc_addresses' => array_values($this->cc),
            'notify_contact' => $this->notifyContact,
            'notify_inquiries' => $this->notifyInquiries,
            'notify_donations' => $this->notifyDonations,
        ]);

        if ($this->password !== '') {
            $s->password = $this->password;
        } elseif (!$this->hasPassword) {
            $s->password = null;
        }

        $s->save();

        $this->password = '';
        $this->hasPassword = filled($s->password);

        return $s;
    }

    public function save()
    {
        $this->testResult = null;
        $this->persist();
        session()->flash('message', 'Email settings saved.');
    }

    public function sendTest()
    {
        $this->testResult = null;

        if (empty($this->to) && trim($this->newTo) === '') {
            $this->addError('to', 'Add at least one “To” recipient to send a test.');
            return;
        }
        if (trim($this->host) === '') {
            $this->addError('host', 'Enter the SMTP host first.');
            return;
        }

        $s = $this->persist();

        try {
            NotificationMailer::sendTest($s);
            $this->testOk = true;
            $this->testResult = 'Test email sent to ' . implode(', ', $s->to_addresses)
                . (empty($s->cc_addresses) ? '' : ' (cc ' . implode(', ', $s->cc_addresses) . ')') . '.';
        } catch (Throwable $e) {
            $this->testOk = false;
            $this->testResult = 'Sending failed: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.manage-mail-settings')->layout('components.layouts.admin');
    }
}
