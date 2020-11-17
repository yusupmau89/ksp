@extends('layouts.adminlte')
@section('head-link')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Purchase Order {{$purchase->nomor_po}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Purchase Order</li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Detail PO
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-md table-striped">
                                <caption>
                                    Tanggal PO : {{$purchase->tanggal_po}}
                                </caption>
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($purchase->lists as $item)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$item->product->nama_produk}}</td>
                                        <td class="text-center">{{$item->jumlah/100 . ' ' . $item->product->satuan_unit}}</td>
                                        <td class="text-right">Rp. {{number_format($item->harga/100, 2, ',', '.')}}</td>
                                        <td class="text-right">Rp. {{number_format($item->jumlah*$item->harga/10000, 2, ',', '.')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">Total</td>
                                        <td class="text-right">Rp. {{number_format(($purchase->grand_total+$purchase->diskon)/100, 2,',','.')}}</td>
                                    </tr>
                                    @if ($purchase->diskon>0)
                                    <tr>
                                        <td colspan="4" class="text-right">Potongan Harga</td>
                                        <td class="text-right">Rp. {{number_format($purchase->diskon/100,2,',','.')}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="4" class="text-right">Total setelah potongan harga</td>
                                        <td class="text-right">Rp. {{number_format($purchase->grand_total/100,2,',','.')}}</td>
                                    </tr>
                                    @if ($purchase->ppn>0)
                                    <tr>
                                        <td colspan="4" class="text-right">PPN 10%</td>
                                        <td class="text-right">Rp. {{number_format($purchase->ppn/100,2,',','.')}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right" colspan="4"><strong>Grand Total</strong></td>
                                        <td class="text-right"><strong>Rp. {{number_format(($purchase->grand_total+$purchase->ppn)/100,2,',','.')}}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Data pengiriman
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        @if ($purchase->suratJalan()->count()==0)
                            <h6 class="card-subtitle text-muted">Belum ada pengiriman</h6>
                        @else
                            <table class="table table-responsive-md table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nomor Surat Jalan</th>
                                        <th class="text-center">Tanggal Pengiriman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($purchase->suratJalan as $surat)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$surat->no_surat_jalan}}</td>
                                        <td>{{date('d F Y',strtotime($surat->tanggal_surat_jalan))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Data Invoice
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        @if ($purchase->invoices()->count()==0)
                            <h6 class="card-subtitle text-muted">Belum ada invoice</h6>
                        @else
                            <table class="table table-responsive-md table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nomor Invoice</th>
                                        <th class="text-center">Tanggal Invoice</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($purchase->invoices as $invoice)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$invoice->nomor_invoice}}</td>
                                        <td>{{$invoice->total}}</td>
                                        <td>{{date('d F Y',strtotime($invoice->tanggal_invoice))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
