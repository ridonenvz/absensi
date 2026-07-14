<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.index', [
            'pegawais' => Pegawai::with(['unitKerja', 'user'])->latest()->get(),
            'unitKerja' => UnitKerja::orderBy('nama_unit')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:50', 'required_without:nik', 'unique:pegawai,nip'],
            'nik' => ['nullable', 'string', 'max:50', 'required_without:nip', 'unique:pegawai,nik'],
            'nama' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'unit_kerja_id' => ['required', 'exists:unit_kerja,id'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'pegawai', 'atasan', 'pimpinan'])],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $nip = blank($validated['nip'] ?? null) ? null : $validated['nip'];
        $nik = blank($validated['nik'] ?? null) ? null : $validated['nik'];

        $pegawai = Pegawai::create([
            'nip' => $nip,
            'nik' => $nik,
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'unit_kerja_id' => $validated['unit_kerja_id'],
            'status' => $validated['status'],
        ]);

        User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'] ?? 'password'),
            'role' => $validated['role'],
            'pegawai_id' => $pegawai->id,
        ]);

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil ditambahkan. Password default: password.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', [
            'pegawai' => $pegawai->load('user'),
            'unitKerja' => UnitKerja::orderBy('nama_unit')->get(),
        ]);
    }

    public function update(Pegawai $pegawai, Request $request)
    {
        $userId = optional($pegawai->user)->id;

        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:50', 'required_without:nik', Rule::unique('pegawai', 'nip')->ignore($pegawai->id)],
            'nik' => ['nullable', 'string', 'max:50', 'required_without:nip', Rule::unique('pegawai', 'nik')->ignore($pegawai->id)],
            'nama' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'unit_kerja_id' => ['required', 'exists:unit_kerja,id'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'role' => ['required', Rule::in(['admin', 'pegawai', 'atasan', 'pimpinan'])],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $nip = blank($validated['nip'] ?? null) ? null : $validated['nip'];
        $nik = blank($validated['nik'] ?? null) ? null : $validated['nik'];

        $pegawai->update([
            'nip' => $nip,
            'nik' => $nik,
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'unit_kerja_id' => $validated['unit_kerja_id'],
            'status' => $validated['status'],
        ]);

        $userData = [
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'pegawai_id' => $pegawai->id,
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $pegawai->user()->updateOrCreate(['pegawai_id' => $pegawai->id], $userData);

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        optional($pegawai->user)->delete();
        $pegawai->delete();

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
