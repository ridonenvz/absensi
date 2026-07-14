<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pegawai = $this->route('pegawai');
        $pegawaiId = is_object($pegawai) ? $pegawai->id : $pegawai;

        return [
            'nama' => ['required', 'string', 'max:150'],
            'nip' => ['nullable', 'string', 'max:50', 'required_without:nik', Rule::unique('pegawai', 'nip')->ignore($pegawaiId)],
            'nik' => ['nullable', 'string', 'max:50', 'required_without:nip', Rule::unique('pegawai', 'nik')->ignore($pegawaiId)],
            'jabatan' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'unit_kerja_id' => ['required', 'exists:unit_kerja,id'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'role' => ['required', Rule::in(['admin', 'pegawai', 'atasan', 'pimpinan'])],
        ];
    }
}
