<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuratJalan;
use App\Http\Requests\UpdateSuratJalan;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\SuratJalan;
use Carbon\Carbon;
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
        $suratJalan = SuratJalan::where('nomor_po', $purchase->id)->orderBy('tanggal_surat_jalan', 'desc')->get();
        return view('login.purchase.surat_jalan.index', compact('suratJalan', 'purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PurchaseOrder $purchase)
    {
        $no = 1;
        $suratJalan = SuratJalan::whereYear('tanggal_surat_jalan', date("Y"))->get();

        if ($suratJalan->count()>0)
            $no += (int)substr($suratJalan->where('id',$suratJalan->max('id'))->first()->no_surat_jalan, 3,3);
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
        //dd($request->all());
        if ($purchase->lists()->sum('sisa')==0)
            return redirect('/purchase')->with('success', 'Gagal membuat Surat Jalan PO dengan nomor '.$purchase->no_po.' sudah terkirim semua');

        $validated = $request->validated();
        //dd($validated);

        $suratJalan = new SuratJalan;
        $suratJalan->no_surat_jalan = $validated['no_surat_jalan'];
        $suratJalan->nomor_po = $validated['no_po'];
        $suratJalan->tanggal_surat_jalan = Carbon::createFromFormat('d/m/Y', $validated['tanggal_surat_jalan']);
        $suratJalan->kendaraan = $validated['kendaraan'];
        $suratJalan->plat_no = $validated['plat_no'];
        $suratJalan->pengirim = $validated['pengirim'];
        $suratJalan->signed_by = $validated['signed_by'];
        $suratJalan->created_by = Auth::user()->id;
        $suratJalan->slug = Str::slug($validated['no_surat_jalan']);

        $suratJalan->save();

        foreach ($validated['list'] as $key=>$list)
        {
            if ($list['jumlah']==0) {continue;}
            $sjList[$key]['jumlah'] = $list['jumlah']*100;
            $sjList[$key]['retur'] = 0;
            $sjList[$key]['purchase_list'] = $list['list'];
            /*
            foreach ($purchase->lists as $data)
            {
                if (Hash::check($data->id,$list['list']) && Hash::check($data->produk, $list['produk'])) {
                    $sjList[$key]['purchase_list']=$data->id;
                    $sjList[$key]['produk']=$data->produk;
                    break;
                }
            }
            */
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
        $sj->kendaraan = $validated['kendaraan'];
        $sj->plat_no = $validated['plat_no'];
        $sj->pengirim = $validated['pengirim'];
        $sj->tanggal_surat_jalan = Carbon::createFromFormat('d/m/Y', $validated['tanggal_surat_jalan']);
        $sj->signed_by = $validated['signed_by'];
        $sj->save();

        foreach ($validated['list'] as $list) {
            $sjList = $sj->lists()->where('no_surat_jalan', $sj->id)->where('purchase_list', $list['purchase_list'])->first();
            $purchaseList = $sjList->purchaseList;
            if ($list['jumlah']===0) {
                $purchaseList->terkirim = $purchaseList->terkirim - $sjList->jumlah + $sjList->retur;
                $purchaseList->sisa = $purchaseList->jumlah - $purchaseList->terkirim;
                $purchaseList->save();
                $sjList->delete();
                continue;
            }
            $purchaseList->terkirim = $purchaseList->terkirim - $sjList->jumlah + ($list['jumlah']*100) + $sjList->retur - ($list['retur']*100);
            $purchaseList->sisa = $purchaseList->jumlah - $purchaseList->terkirim;
            $purchaseList->save();
            $sjList->jumlah = $list['jumlah']*100;
            $sjList->retur = $list['retur']*100;
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
        if ($purchase->status === 'Completed')
            $purchase->status = 'Partially Invoiced';
        $purchase->save();

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
