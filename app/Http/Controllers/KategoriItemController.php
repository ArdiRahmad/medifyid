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

    public function create()
    {
        return view('kategori-items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kategori_items,kode',
            'nama' => 'required'
        ]);

        KategoriItem::create($request->only(['kode', 'nama']));

        return redirect()->route('kategori-items.index');
    }

    public function show($id)
    {
        $kategori = KategoriItem::with('masterItems')->findOrFail($id);
        return view('kategori-items.show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = KategoriItem::findOrFail($id);
        return view('kategori-items.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriItem::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:kategori_items,kode,' . $kategori->id,
            'nama' => 'required'
        ]);

        $kategori->update($request->only(['kode', 'nama']));

        return redirect()->route('kategori-items.index');
    }

    public function destroy($id)
    {
        KategoriItem::findOrFail($id)->delete();
        return redirect()->route('kategori-items.index');
    }
}
