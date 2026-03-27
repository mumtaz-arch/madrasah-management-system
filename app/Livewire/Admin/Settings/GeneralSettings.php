<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\AppSetting;
use Illuminate\Contracts\View\View;

class GeneralSettings extends Component
{
    public $settings = [
        'rfid_late_threshold' => '',
        'rfid_checkin_start' => '',
        'rfid_checkin_end' => '',
        'rfid_checkout_start' => '',
        'rfid_checkout_end' => '',
        'msg_unregistered_card' => '',
        'msg_checkin_success' => '',
        'msg_checkout_success' => '',
        'msg_outside_hours' => '',
        'journal_open_time' => '',
        'journal_close_time' => '',
    ];

    public function mount()
    {
        // Load settings from DB
        $dbSettings = AppSetting::whereIn('key', array_keys($this->settings))->get()->keyBy('key');
        
        foreach ($this->settings as $key => $value) {
            if ($dbSettings->has($key)) {
                $this->settings[$key] = $dbSettings->get($key)->value;
            }
        }
    }

    public function rules()
    {
        return [
            'settings.rfid_late_threshold' => ['required', 'string', 'date_format:H:i'],
            'settings.rfid_checkin_start' => ['required', 'string', 'date_format:H:i'],
            'settings.rfid_checkin_end' => ['required', 'string', 'date_format:H:i', 'after:settings.rfid_checkin_start'],
            'settings.rfid_checkout_start' => ['required', 'string', 'date_format:H:i'],
            'settings.rfid_checkout_end' => ['required', 'string', 'date_format:H:i', 'after:settings.rfid_checkout_start'],
            
            'settings.msg_unregistered_card' => ['required', 'string', 'max:255'],
            'settings.msg_checkin_success' => ['required', 'string', 'max:255'],
            'settings.msg_checkout_success' => ['required', 'string', 'max:255'],
            'settings.msg_outside_hours' => ['required', 'string', 'max:255'],

            'settings.journal_open_time' => ['required', 'string', 'date_format:H:i'],
            'settings.journal_close_time' => ['required', 'string', 'date_format:H:i', 'after:settings.journal_open_time'],
        ];
    }
    
    public function messages()
    {
        return [
            'settings.*.after' => 'Waktu akhir harus lebih besar dari waktu mulai.',
            'settings.*.date_format' => 'Format jam tidak valid (Harus HH:MM).',
            'settings.*.required' => 'Pengaturan ini wajib diisi.',
            'settings.*.max' => 'Pesan maksimal 255 karakter.',
        ];
    }

    public function save()
    {
        $this->validate();

        foreach ($this->settings as $key => $value) {
            AppSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        session()->flash('success', 'Pengaturan berhasil disimpan!');
    }

    public function render(): View
    {
        return view('livewire.admin.settings.general-settings')->layout('components.layouts.admin', ['title' => 'Pengaturan Umum']);
    }
}
