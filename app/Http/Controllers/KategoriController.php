<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::orderBy('kategori', 'asc')->get();
        $pilih = $kategori;
        return view('login.kategori.index', compact('kategori', 'pilih'));
    }

    public function store(Request $request) {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'kategori' => 'required|unique:categories,kategori',
            'deskripsi' => 'required',
        ],[
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
        ])->validate();

        Kategori::create([
            'kategori' => strtoupper($validator['kategori']),
            'deskripsi' => ucwords(strtolower($validator['deskripsi'])),
        ]);

        return redirect('kategori')->with('success', 'Kategori berhasil ditambah');
    }

    public function update(Request $request, Kategori $kategori) {
        $validator = Validator::make($request->all(),[
            'kategori' => 'required|unique:categories,kategori,'.$kategori->id,
            'deskripsi' => 'required',
            'parent_id' => 'nullable',
        ],[
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
        ])->validate();

        $kategori->kategori = strtoupper($validator['kategori']);
        $kategori->deskripsi = ucwords(strtolower($validator['deskripsi']));
        $kategori->parent_id = Kategori::find($validator['parent_id'])==null?null:Kategori::find($validator['parent_id'])->id;
        $kategori->save();

        return redirect('kategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Kategori $kategori) {
        $kategori->delete();
        return redirect('kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
