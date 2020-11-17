<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListPo;
use App\Models\Pengguna as Customer;
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
        $customers = Customer::orderBy('nama', 'asc')->get();
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

        $po->nomor_po = $validated['no_po'];
        $po->customer_id = $validated['customer'];
        $po->tanggal_po = Carbon::createFromFormat('d/m/Y',$validated['tanggal_po'])->format('Y/m/d');
        $po->tanggal_kirim = Carbon::createFromFormat('d/m/Y',$validated['tanggal_kirim'])->format('Y/m/d');
        $po->top = $validated['top'];
        $po->ppn = 0;
        $po->diskon = 0;
        $po->grand_total = 0;
        $po->created_by = Auth::user()->id;
        $po->status = 'On Progress';
        $po->slug = Str::slug($validated['no_po']);

        $po->save();
        $grandTotal = 0;
        $diskon = 0;

        foreach ($validated['product'] as $product) {
            $grandTotal += ($product['harga']*$product['jumlah'])-$product['diskon'];
            $diskon += $product['diskon'];
            $po->lists()->create([
                'produk' => $product['produk'],
                'jumlah' => $product['jumlah']*100,
                'harga' => $product['harga']*100,
                'subtotal' => (($product['harga']*$product['jumlah'])-$product['diskon'])*100,
                'diskon' => $product['diskon']*100,
                'terkirim' => 0,
                'sisa' => $product['jumlah']*100,
            ]);
        }

        strtolower($validated['ppn'])==='ya' ? $po->ppn = floor($grandTotal*0.1)*100 : $po->ppn=0;

        $po->grand_total = $grandTotal*100; $po->diskon = $diskon*100; $po->save();

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
        return view('login.purchase.show', compact('purchase'));
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
        foreach ($purchase->suratJalan as $item) {
            $item->delete();
        }
        foreach ($purchase->invoices as $item) {
            $item->delete();
        }
        $purchase->delete();

        return redirect('/purchase')->with('success', 'PO berhasil dihapus');
    }
}
