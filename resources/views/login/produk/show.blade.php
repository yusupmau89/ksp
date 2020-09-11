@extends('layouts.adminlte')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Produk &amp; Layanan</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/product">Produk</a></li>
                <li class="breadcrumb-item active">Detail Produk</li>
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
                                {{$product->nama_produk}}
                            </h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                            @endif
                            <table class="table table-responsive-md">
                                <tbody>
                                    <tr>
                                        @if (!empty($product->drawing))
                                        @if (pathinfo($product->drawing, PATHINFO_EXTENSION)==='pdf')
                                        <td rowspan="5">
                                            <embed src="{{asset('storage/'.$product->drawing)}}" type="pdf">
                                        </td>
                                        @else
                                        <td rowspan="5">
                                            <img class="img-fluid img-thumbnail" src="{{asset('storage/'.$product->drawing)}}" alt="No Data">
                                        </td>
                                        @endif
                                        @endif
                                        <td>Kode Produk</td>
                                        <td>:</td>
                                        <td>{{$product->kode_produk}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Produk</td>
                                        <td>:</td>
                                        <td>{{$product->nama_produk}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>:</td>
                                        <td>{{$product->kategori}}</td>
                                    </tr>
                                    <tr>
                                        <td>Satuan Unit</td>
                                        <td>:</td>
                                        <td>{{$product->satuan_unit}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td>Rp. {{number_format($product->harga, 2, ',', '.')}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"><small class="text-muted">Diinput pertama kali oleh {{$product->user->name}} pada {{$product->getDateCreated()}}</small></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><small class="text-muted">Diubah terakhir kali pada {{$product->getDateModified()}}</small></td>
                                    </tr>
                                </tfoot>
                            </table>
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
