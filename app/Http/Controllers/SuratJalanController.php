<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuratJalan;
use App\Http\Requests\UpdateSuratJalan;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SuratJalan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDF;

class SuratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchaseOrder $purchase)
    {
        $suratJalan = SuratJalan::where('no_po', $purchase->id)->orderBy('tanggal_surat_jalan', 'asc')->get();
        return view('login.purchase.surat_jalan.index', compact('suratJalan', 'purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PurchaseOrder $purchase)
    {
        $suratJalan = SuratJalan::whereYear('tanggal_surat_jalan', date("Y"))->get();
        $no = $suratJalan->count()+1;
        $nomor = 'SJ-'. str_pad($no, 3, '0', STR_PAD_LEFT).'/KSP/'.date('m').'/'.date('y');

        return view('login.purchase.surat_jalan.create', compact('nomor', 'purchase'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuratJalan $request, PurchaseOrder $purchase)
    {
        $validated = $request->validated();
        //dd($validated, $purchase);

        $suratJalan = new SuratJalan;
        $suratJalan->no_surat_jalan = $validated['no_surat_jalan'];
        $suratJalan->no_po = $purchase->id;
        $suratJalan->tanggal_surat_jalan = Carbon::createFromFormat('d/m/Y', $validated['tanggal_surat_jalan']);
        $suratJalan->signed_by = $validated['signed_by'];
        $suratJalan->created_by = Auth::user()->id;
        $suratJalan->slug = Str::slug($validated['no_surat_jalan']);

        $suratJalan->save();

        foreach ($validated['list'] as $key=>$list)
        {
            $sjList[$key]['jumlah'] = $list['jumlah'];
            $sjList[$key]['retur'] = 0;
            foreach ($purchase->lists as $data)
            {
                if (Hash::check($data->id,$list['list']) && Hash::check($data->produk, $list['produk'])) {
                    $sjList[$key]['purchase_list']=$data->id;
                    $sjList[$key]['produk']=$data->produk;
                    break;
                }
            }
            $purchaseList = $purchase->lists()->find($sjList[$key]['purchase_list']);
            $purchaseList->terkirim += $sjList[$key]['jumlah'];
            $purchaseList->sisa = $purchaseList->jumlah-$purchaseList->terkirim;
            $purchaseList->save();
        }
        $suratJalan->lists()->createMany($sjList);
        if ($purchase->status=='On Progress') $purchase->status = 'Partially Delivered';
        $purchase->save();
        return redirect('/purchase/'.$purchase->slug.'/sj')->with('success', 'Surat Jalan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchase, SuratJalan $sj)
    {
        $pdf = PDF::loadView('login.purchase.surat_jalan.show', ['sj'=>$sj]);
        return $pdf->stream('Surat Jalan '.$purchase->no_po.'.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchase, SuratJalan $sj)
    {
        return view('login.purchase.surat_jalan.edit', compact('purchase', 'sj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuratJalan $request, PurchaseOrder $purchase, SuratJalan $sj)
    {
        $validated = $request->validated();

        $sj->no_surat_jalan = $validated['no_surat_jalan'];
        $sj->tanggal_surat_jalan = Carbon::createFromFormat('d/m/Y', $validated['tanggal_surat_jalan']);
        $sj->signed_by = $validated['signed_by'];
        $sj->save();

        foreach ($validated['list'] as $list) {
            foreach ($purchase->lists as $cari) {
                if (Hash::check($cari->id, $list['purchase_list'])) $purchaseList = $cari;
            }
            $sjList = $purchaseList->sjList;
            $purchaseList->terkirim = $purchaseList->terkirim - $sjList->jumlah + $list['jumlah'] + $sjList->retur - $list['retur'];
            $purchaseList->sisa = $purchaseList->jumlah - $purchaseList->terkirim;
            $purchaseList->save();
            $sjList->jumlah = $list['jumlah'];
            $sjList->retur = $list['retur'];
            $sjList->save();
        }

        return redirect('/purchase/'.$purchase->slug.'/sj')->with('success', 'Surat Jalan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchase, SuratJalan $sj)
    {
        foreach ($sj->lists as $list) {
            $purchaseList = $purchase->lists()->find($list->purchase_list);
            $purchaseList->terkirim -= $list->jumlah;
            $purchaseList->sisa = $purchaseList->jumlah - $purchaseList->terkirim;
            $purchaseList->save();
            $list->delete();
        }
        $sj->delete();

        return redirect('/purchase/'.$purchase->slug.'/sj')->with('success', 'Surat Jalan berhasil dihapus');
    }
}
