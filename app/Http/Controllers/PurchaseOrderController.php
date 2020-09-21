<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListPo;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = PurchaseOrder::orderBy('tanggal_po', 'asc')->get();
        return view('login.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::orderBy('nama_customer', 'asc')->get();
        $products = Product::orderBy('nama_produk', 'asc')->get();
        return view('login.purchase.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListPo $request)
    {
        $validated = $request->validated();
        $po = new PurchaseOrder;

        $po->no_po = $validated['no_po'];
        $po->customer = $validated['customer'];
        $po->tanggal_po = Carbon::createFromFormat('d/m/Y',$validated['tanggal_po'])->format('Y/m/d');
        $po->tanggal_kirim = Carbon::createFromFormat('d/m/Y',$validated['tanggal_po'])->format('Y/m/d');
        $po->top = $validated['top'];
        $po->down_payment = $validated['down_payment'];
        $po->created_by = Auth::user()->id;
        $po->slug = Str::slug($validated['no_po']);

        $po->save();

        foreach ($validated['product'] as $product) {
            $po->lists()->create([
                'produk' => $product['produk'],
                'jumlah' => $product['jumlah'],
                'harga' => $product['harga'],
            ]);

            $po->pengiriman()->create([
                'produk' => $product['produk'],
                'terkirim' => 0,
                'sisa' => $product['jumlah'],
            ]);
        }

        $po->statusPo()->create([
            'status' => strtoupper('on progress'),
        ]);

        return redirect('purchase')->with('success', 'PO berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchase)
    {
        foreach ($purchase->lists as $item) {
            $item->delete();
        }
        foreach ($purchase->pengiriman as $item) {
            $item->delete();
        }
        $purchase->statusPo->delete();
        $purchase->delete();

        return redirect('/purchase')->with('success', 'PO berhasil dihapus');
    }
}
