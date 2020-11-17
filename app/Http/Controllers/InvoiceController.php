<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoice;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchaseOrder $purchase)
    {
        $invoices = Invoice::where('nomor_po', $purchase->id)->orderBy('tanggal_invoice', 'desc')->get();
        return view('login.purchase.invoice.index', compact('invoices', 'purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PurchaseOrder $purchase)
    {
        $invoices = $purchase->invoices;
        $no = 1;
        $id = [];

        if ($invoices->count()>0) {
            foreach ($invoices as $invoice) {
                foreach ($invoice->lists as $list)
                    array_push($id, $list->surat_jalan);
            }
        }

        $year = Invoice::whereYear('tanggal_invoice', date("Y"))->get();
        if ($year->count()>0)
            $no += (int)substr($year->where('id', $year->max('id'))->first()->no_invoice,4,3);
        $noInvoice = 'INV-'. str_pad($no, 3, '0', STR_PAD_LEFT).'/KSP/'.date('m').'/'.date('y');
        $suratJalan = $purchase->suratJalan()->whereNotIn('id', $id)->get()->all();

        return view('login.purchase.invoice.create', compact('noInvoice', 'purchase', 'suratJalan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrder $purchase, StoreInvoice $request)
    {
        $validated = $request->validated();

        $invoice = new Invoice;
        $invoice->nomor_po = $purchase->id;
        $invoice->no_invoice = $validated['no_invoice'];
        $invoice->tanggal_invoice = Carbon::createFromFormat('d/m/Y', $validated['tanggal_invoice']);
        $invoice->signed_by = $validated['signed_by'];
        $invoice->slug = Str::slug($validated['no_invoice']);
        $invoice->created_by = Auth::user()->id;
        $invoice->jumlah = $validated['jumlah'];
        $invoice->save();

        if (isset($validated['list'])) {
            foreach($validated['list'] as $key=>$data) {
                foreach($purchase->suratJalan as $surat) {
                    if (Hash::check($surat->id, $data['surat_jalan'])) {
                        $invoiceList[$key]['surat_jalan'] = $surat->id;
                        $invoiceList[$key]['jumlah'] = 0;
                        foreach ($surat->lists as $listSj) {
                            $invoiceList[$key]['jumlah'] += (($listSj->jumlah-$listSj->retur) * $listSj->purchaseList->harga);
                        }
                    }
                }
            }
        }
        $invoice->lists()->createMany($invoiceList);
        $invoice->jumlah += $invoice->lists()->sum('jumlah');
        if ($purchase->ppn === 'Ya')
            $invoice->jumlah = floor($invoice->jumlah*1.1);
        $count = 0;
        foreach ($purchase->invoices as $countInvoice)
        {
            $count+= $countInvoice->lists()->count('surat_jalan');
        }
        $countSurat = $purchase->suratJalan()->count();
        $sumSurat = 0;
        foreach ($purchase->suratJalan as $sj) {
            $sumSurat+= ($sj->lists()->sum('jumlah') - $sj->lists()->sum('retur'));
        }
        $purchase->status = 'Partially Invoiced';
        if ($count == $countSurat && $sumSurat == $purchase->lists()->sum('jumlah'))
            $purchase->status = 'Completed';
        $invoice->save();
        $purchase->save();

        return redirect('/purchase/'.$purchase->slug.'/invoice')->with('success', 'Invoice berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchase, Invoice $invoice)
    {
        $products = $invoice->lists()
            ->rightJoin('surat_jalans', 'invoice_lists.surat_jalan','=','surat_jalans.id')
            ->leftJoin('sj_lists', 'surat_jalans.id', '=', 'sj_lists.surat_jalan')
            ->join('purchase_lists', 'purchase_lists.id', '=', 'sj_lists.purchase_list')
            ->join('products', 'products.id', '=', 'sj_lists.produk')
            ->select('sj_lists.purchase_list', 'products.kode_produk', 'products.nama_produk', 'products.satuan_unit', 'purchase_lists.harga', DB::raw('sum(sj_lists.jumlah) as jumlah, sum(sj_lists.retur) as retur, sum((sj_lists.jumlah-sj_lists.retur)*purchase_lists.harga) as subtotal'))
            ->groupBy('sj_lists.purchase_list', 'products.kode_produk', 'products.nama_produk', 'products.satuan_unit', 'purchase_lists.harga')
            ->get();
        //dd($products);
            /*
        $products = [];
        foreach ($invoice->lists as $list) {
            foreach ($list->suratJalan->lists as $item) {
                if(array_key_exists($item->product->kode_produk, $products)){
                    $products[$item->product->kode_produk]['jumlah'] += ($item->jumlah-$item->retur);
                } else {
                    $products[$item->product->kode_produk]['nama_produk'] = $item->product->nama_produk;
                    $products[$item->product->kode_produk]['satuan_unit'] = $item->product->satuan_unit;
                    $products[$item->product->kode_produk]['harga'] = $item->purchaseList->harga;
                    $products[$item->product->kode_produk]['jumlah'] = ($item->jumlah-$item->retur);
                }
            }
        }
        */
        $pdf = PDF::loadView('login.purchase.invoice.show', ['invoice'=>$invoice, 'products'=>$products]);
        return $pdf->stream('Invoice '.$purchase->no_po.'.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchase, Invoice $invoice)
    {
        foreach ($invoice->lists as $list) {
            $list->delete();
        }
        $invoice->delete();
        if ($purchase->status === 'Completed')
            $purchase->status = 'Partially Invoiced';
        if ($purchase->invoices()->count()==0)
            $purchase->status = 'Partially Delivered';
        $purchase->save();
        return redirect('/purchase/'.$purchase->slug.'/invoice')->with('success', 'Invoice berhasil dihapus');
    }
}
