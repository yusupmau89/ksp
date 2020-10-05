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
            <div class="col-sm-8">
            <h1>Surat Jalan {{$purchase->no_po.' | '.$purchase->customer->nama_customer}}</h1>
            </div>
            <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Surat Jalan</li>
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
                                Data Surat Jalan
                                <a href="{{route('sj.create', $purchase)}}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Buat Surat Jalan
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
                                        <th>Nomor Surat Jalan</th>
                                        <th>Tanggal Kirim</th>
                                        <th>TTD</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($suratJalan as $sj)
                                    <tr>
                                        <td>
                                            <a href="{{route('sj.show', [$purchase, $sj])}}">
                                                {{$sj->no_surat_jalan}}
                                            </a>
                                        </td>
                                        <td>{{$sj->tanggal_surat_jalan}}</td>
                                        <td>{{$sj->signed_by}}</td>
                                        <td>
                                            <a href="{{route('sj.edit', [$purchase, $sj])}}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pencil-alt"></i> Ubah
                                            </a>
                                            <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" href="#hapus-{{$sj->slug}}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                Hapus
                                            </a>
                                        </td>
                                        <div class="modal fade" id="hapus-{{$sj->slug}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Apakah {{$sj->no_surat_jalan}}akan dihapus?</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah akan dihapus?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    <form action="{{route('sj.destroy', [$purchase, $sj])}}" method="post">
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
                                        <td colspan="4">Surat Jalan masih kosong, silakan tambah terlebih dahulu</td>
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
        /*
        $('#purchase').DataTable({
            "responsive" : false,
            "autoWidth" : false,
            "scrollX" : true,
        });
        */
    });
</script>
@endsection
