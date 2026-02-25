<?php

namespace App\Livewire\Wali;

use App\Models\Message;
use App\Models\Santri;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatWaliKelas extends Component
{
    public ?int $selectedSantriId = null;
    public string $newMessage = '';
    
    public function mount()
    {
        $wali = Auth::user()->wali;
        if ($wali) {
            $firstSantri = Santri::where('wali_id', $wali->id)->first();
            if ($firstSantri) {
                $this->selectedSantriId = $firstSantri->id;
            }
        }
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage)) || !$this->selectedSantriId) {
            return;
        }

        $santri = Santri::with('kelas.waliKelas.user')->find($this->selectedSantriId);
        
        if (!$santri || !$santri->kelas || !$santri->kelas->waliKelas) {
            session()->flash('error', 'Wali kelas tidak ditemukan.');
            return;
        }

        $waliKelasUser = $santri->kelas->waliKelas->user;

        Message::create([
            'santri_id' => $this->selectedSantriId,
            'sender_id' => Auth::id(),
            'receiver_id' => $waliKelasUser->id,
            'message' => trim($this->newMessage),
        ]);

        $this->newMessage = '';
        session()->flash('success', 'Pesan terkirim!');
    }

    public function markAsRead($messageId)
    {
        Message::where('id', $messageId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);
    }

    public function render()
    {
        $wali = Auth::user()->wali;
        $santris = collect();
        $messages = collect();
        $selectedSantri = null;
        $waliKelas = null;

        if ($wali) {
            $santris = Santri::where('wali_id', $wali->id)->get();

            if ($this->selectedSantriId) {
                $selectedSantri = Santri::with('kelas.waliKelas.user')->find($this->selectedSantriId);
                
                if ($selectedSantri && $selectedSantri->kelas && $selectedSantri->kelas->waliKelas) {
                    $waliKelas = $selectedSantri->kelas->waliKelas;
                    
                    // Get messages
                    $messages = Message::with(['sender', 'receiver'])
                        ->where('santri_id', $this->selectedSantriId)
                        ->where(function($q) use ($waliKelas) {
                            $q->where(function($q2) use ($waliKelas) {
                                $q2->where('sender_id', Auth::id())
                                   ->where('receiver_id', $waliKelas->user_id);
                            })->orWhere(function($q2) use ($waliKelas) {
                                $q2->where('sender_id', $waliKelas->user_id)
                                   ->where('receiver_id', Auth::id());
                            });
                        })
                        ->orderBy('created_at', 'asc')
                        ->get();

                    // Mark unread as read
                    Message::where('santri_id', $this->selectedSantriId)
                        ->where('receiver_id', Auth::id())
                        ->where('is_read', false)
                        ->update(['is_read' => true]);
                }
            }
        }

        return view('livewire.wali.chat-wali-kelas', [
            'santris' => $santris,
            'selectedSantri' => $selectedSantri,
            'messages' => $messages,
            'waliKelas' => $waliKelas,
        ]);
    }
}
