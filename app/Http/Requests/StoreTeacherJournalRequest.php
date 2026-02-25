<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherJournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'guru';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today'],
            'class_id' => ['required', 'exists:kelas,id'],
            'subject_id' => ['required', 'exists:mapels,id'],
            'topic' => ['required', 'string', 'max:255'],
            'method' => ['required', 'string', 'max:255'],
            'present_count' => ['required', 'integer', 'min:0'],
            'absent_count' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,sent'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'Tanggal jurnal tidak boleh di masa depan.',
            'class_id.required' => 'Kelas harus dipilih.',
            'subject_id.required' => 'Mata pelajaran harus dipilih.',
        ];
    }
}
