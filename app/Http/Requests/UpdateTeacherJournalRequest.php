<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TeacherJournal;

class UpdateTeacherJournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Policy determines this
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'date' => ['required', 'date', 'before_or_equal:today'],
            'class_id' => ['required', 'exists:kelas,id'],
            'subject_id' => ['required', 'exists:mapels,id'],
            'topic' => ['required', 'string', 'max:255'],
            'method' => ['required', 'string', 'max:255'],
            'present_count' => ['required', 'integer', 'min:0'],
            'absent_count' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];

        // Admin might update status to verified, but Guru should only be able to update to draft or sent
        if ($this->user()->role === 'guru') {
            $rules['status'] = ['required', 'in:draft,sent'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'Tanggal jurnal tidak boleh di masa depan.',
        ];
    }
}
