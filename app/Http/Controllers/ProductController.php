<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('kode_produk', 'asc')->get();
        return view('login.produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('login.produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $validated = $request->validated();

        $product = new Product;
        $product->kode_produk = $validated['kode_produk'];
        $product->nama_produk = $validated['nama_produk'];
        $product->jenis_produk = $validated['jenis_produk'];
        $product->kategori = $validated['kategori'];
        $product->satuan_unit = $validated['satuan_unit'];
        $product->harga = $validated['harga'];
        $product->created_by = Auth::user()->id;
        $product->slug = Str::slug(strtolower($validated['nama_produk']));

        if (!empty($validated['drawing']))
        {
            $extension = strtolower($validated['drawing']->getClientOriginalExtension());
            $product->drawing = $validated['drawing']->storeAs('products', time().'.'.$extension, 'public');
        }
        $product->save();

        return redirect('/product')->with('success', 'Produk berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('login.produk.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $kategori = Kategori::all();
        return view('login.produk.edit', compact('product', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, Product $product)
    {
        $validated = $request->validated();

        $product->kode_produk = $validated['kode_produk'];
        $product->nama_produk = $validated['nama_produk'];
        $product->jenis_produk = $validated['jenis_produk'];
        $product->kategori = $validated['kategori'];
        $product->satuan_unit = $validated['satuan_unit'];
        $product->harga = $validated['harga'];
        $product->slug = Str::slug(strtolower($validated['nama_produk']));

        if (!empty($validated['drawing'])){
            if (!empty($product->drawing))
                Storage::disk('public')->delete($product->drawing);
            $extension = $validated['drawing']->getClientOriginalExtension();
            $product->drawing = $validated['drawing']->storeAs('products', time().'.'.$extension, 'public');
        }
        $product->save();

        return redirect('/product')->with('success', 'Produk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(!empty($product->drawing))
            Storage::disk('public')->delete($product->drawing);
        $product->delete();
        return redirect('/product')->with('success', 'Produk berhasil dihapus');
    }
}
