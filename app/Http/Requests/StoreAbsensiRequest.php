<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'tipe_absen' => 'required|in:masuk,pulang',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ];
    }
}