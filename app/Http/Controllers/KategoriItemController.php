<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Illuminate\Http\Request;

class KategoriItemController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriItem::query();

        if ($request->filled('kode')) {
            $query->where('kode', 'like', '%' . $request->kode . '%');
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $kategori = $query->orderBy('id', 'desc')->paginate(10);

        return view('kategori-items.index', compact('kategori'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('kategori-items.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kategori_items,kode',
            'nama' => 'required',
        ]);

        KategoriItem::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori-items.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Detail kategori dan items yang berelasi.
     */
    public function show(KategoriItem $kategoriItem)
    {
        // ambil semua items yang punya kategori ini
        $items = $kategoriItem->items;

        return view('kategori-items.show', compact('kategoriItem', 'items'));
    }

    /**
     * Form edit kategori.
     */
    public function edit(KategoriItem $kategoriItem)
    {
        return view('kategori-items.edit', compact('kategoriItem'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, KategoriItem $kategoriItem)
    {
        $request->validate([
            'kode' => 'required|unique:kategori_items,kode,' . $kategoriItem->id,
            'nama' => 'required',
        ]);

        $kategoriItem->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori-items.index')->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(KategoriItem $kategoriItem)
    {
        $kategoriItem->delete();

        return redirect()->route('kategori-items.index')->with('success', 'Kategori berhasil dihapus');
    }
}
