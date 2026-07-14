<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JamKerjaController extends Controller
{
    private array $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    public function index()
    {
        return view('jam-kerja.index', [
            'data' => JamKerja::orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 ELSE 8 END")->get(),
            'hari' => $this->hari,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => ['required', Rule::in($this->hari), 'unique:jam_kerja,hari'],
            'jam_masuk' => ['nullable', 'date_format:H:i'],
            'jam_pulang' => ['nullable', 'date_format:H:i'],
            'is_wfh' => ['nullable', 'boolean'],
        ]);

        JamKerja::create([
            'hari' => $validated['hari'],
            'jam_masuk' => $validated['jam_masuk'] ?? null,
            'jam_pulang' => $validated['jam_pulang'] ?? null,
            'is_wfh' => $request->boolean('is_wfh'),
        ]);

        return redirect('/jam-kerja')->with('success', 'Jadwal kerja berhasil ditambahkan.');
    }

    public function edit(JamKerja $jamKerja)
    {
        return view('jam-kerja.edit', ['jamKerja' => $jamKerja, 'hari' => $this->hari]);
    }

    public function update(JamKerja $jamKerja, Request $request)
    {
        $validated = $request->validate([
            'hari' => ['required', Rule::in($this->hari), Rule::unique('jam_kerja', 'hari')->ignore($jamKerja->id)],
            'jam_masuk' => ['nullable', 'date_format:H:i'],
            'jam_pulang' => ['nullable', 'date_format:H:i'],
            'is_wfh' => ['nullable', 'boolean'],
        ]);

        $jamKerja->update([
            'hari' => $validated['hari'],
            'jam_masuk' => $validated['jam_masuk'] ?? null,
            'jam_pulang' => $validated['jam_pulang'] ?? null,
            'is_wfh' => $request->boolean('is_wfh'),
        ]);

        return redirect('/jam-kerja')->with('success', 'Jadwal kerja berhasil diperbarui.');
    }

    public function destroy(JamKerja $jamKerja)
    {
        $jamKerja->delete();

        return redirect('/jam-kerja')->with('success', 'Jadwal kerja berhasil dihapus.');
    }
}
