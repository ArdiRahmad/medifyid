<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) {
            $data_search->where('kode', $kode);
        }

        if (!empty($nama)) {
            $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        if (!empty($hargamin) && !empty($hargamax)) {
            $data_search->whereBetween('harga_beli', [$hargamin, $hargamax]);
        } elseif (!empty($hargamin)) {
            $data_search->where('harga_beli', '>=', $hargamin);
        } elseif (!empty($hargamax)) {
            $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search
            ->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'img_url', 'kategori_item_id')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data'   => $data_search,
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::find($id);
        }

        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategoriItems'] = \App\Models\KategoriItem::all(); // ambil kategori

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(1);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        if ($request->hasFile('img_url')) {
            $imagePath = $request->file('img_url')->store('uploads/content', 'public');
            $data_item->img_url = 'storage/' . $imagePath;
        }

        $data_item->nama            = $request->nama ?? null;
        $data_item->harga_beli      = $request->harga_beli ?? null;
        $data_item->laba            = $request->laba ?? null;
        $data_item->kode            = $kode;
        $data_item->supplier        = $request->supplier ?? null;        
        $data_item->jenis           = $request->jenis ?? null;           
        $data_item->kategori_item_id = $request->kategori_item_id ?? null;

        $data_item->save();

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)?->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
