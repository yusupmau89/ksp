@extends('layouts.adminlte')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Customer</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/customer">Customer</a></li>
                <li class="breadcrumb-item active">Detail Customer</li>
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
                                {{$customer->nama}}
                            </h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                            @endif
                            <table class="table table-responsive-md">
                                <tbody>
                                    <tr>
                                        <td>Nama Customer</td>
                                        <td>:</td>
                                        <td>{{$customer->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>NPWP</td>
                                        <td>:</td>
                                        <td>{{$customer->npwp}}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pengiriman</td>
                                        <td>:</td>
                                        <td>{{$customer->alamats()->where('ref_alamat_id', 1)->first()->nama_jalan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Penagihan</td>
                                        <td>:</td>
                                        <td>{{$customer->alamats()->where('ref_alamat_id', 2)->first()->nama_jalan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Email</td>
                                        <td>:</td>
                                        <td>{{$customer->emails()->first()->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Telepon</td>
                                        <td>:</td>
                                        <td>{{$customer->telepons()->first()->noTelp()}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"><small class="text-muted">Diinput pertama kali oleh {{$customer->user->name}} pada {{$customer->getDateCreated()}}</small></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><small class="text-muted">Diubah terakhir kali pada {{$customer->getDateModified()}}</small></td>
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
