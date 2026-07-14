<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitKerjaController extends Controller
{
    public function index()
    {
        return view('unit-kerja.index', [
            'unitKerja' => UnitKerja::withCount('pegawai')->orderBy('nama_unit')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => ['required', 'string', 'max:150', 'unique:unit_kerja,nama_unit'],
        ]);

        UnitKerja::create($validated);

        return redirect('/unit-kerja')->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('unit-kerja.edit', compact('unitKerja'));
    }

    public function update(UnitKerja $unitKerja, Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => ['required', 'string', 'max:150', Rule::unique('unit_kerja', 'nama_unit')->ignore($unitKerja->id)],
        ]);

        $unitKerja->update($validated);

        return redirect('/unit-kerja')->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        if ($unitKerja->pegawai()->exists()) {
            return back()->with('error', 'Unit kerja tidak dapat dihapus karena masih digunakan pegawai.');
        }

        $unitKerja->delete();

        return redirect('/unit-kerja')->with('success', 'Unit kerja berhasil dihapus.');
    }
}
