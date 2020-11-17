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
            <h1>Purchase Order</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Purchase Order</li>
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
                                Data Purchase Order
                                <a href="{{route('purchase.create')}}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah PO
                                </a>
                            </h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                            @endif
                            <table class="table table-bordered table-striped" id="purchase">
                                <thead>
                                    <tr>
                                        <th>Nomor PO</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        <th style="display: none;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($purchases as $purchase)
                                    <tr>
                                        <td>
                                            <a href="{{route('purchase.show', $purchase)}}">
                                                {{$purchase->nomor_po}}
                                            </a>
                                        </td>
                                        <td>{{$purchase->tanggal_kirim}}</td>
                                        <td>{{$purchase->status}}</td>
                                        <td>
                                            <a href="{{route('sj.index', $purchase)}}" data-toggle="tooltip" title="Surat Jalan" class="btn btn-success btn-sm"><i class="fas fa-truck-pickup"></i></a>
                                            <a href="{{route('invoice.index', $purchase)}}" data-toggle="tooltip" title="Invoice" class="btn btn-sm btn-primary"><i class="fas fa-file-invoice"></i></a>
                                            <a href="{{route('purchase.edit', $purchase)}}" data-toggle="tooltip" title="Ubah" class="btn btn-sm btn-warning">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" href="#hapus-{{$purchase->slug}}">
                                                <i data-toggle="tooltip" title="hapus" class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td style="display: none;">{{$purchase->customer->nama}}</td>
                                        <div class="modal fade" id="hapus-{{$purchase->slug}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{$purchase->no_po}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah {{$purchase->no_po}} akan dihapus?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    <form action="{{route('purchase.destroy', $purchase)}}" method="post">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">Purchase Order masih kosong, silakan tambah terlebih dahulu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
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
@section('scripts')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(function(){
        $('#purchase').DataTable({
            "responsive" : false,
            "autoWidth" : false,
            "scrollX" : true,
        });
    });
</script>
@endsection
