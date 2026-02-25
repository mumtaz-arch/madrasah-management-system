<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GuruResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nip' => $this->nip,
            'nama_lengkap' => $this->nama_lengkap,
            'jabatan' => $this->jabatan,
            'bidang_keahlian' => $this->bidang_keahlian,
            'foto_url' => $this->foto ? Storage::url($this->foto) : null,
            'status' => $this->status,
        ];
    }
}
