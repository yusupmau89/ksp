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
            <h1>Customer</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Customer</li>
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
                                Data Customer
                                <a href="{{route('customer.create')}}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah Customer
                                </a>
                            </h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                            @endif
                            <table class="table table-bordered table-striped" id="customer">
                                <thead>
                                    <tr>
                                        <th>Nama Customer</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                    <tr>
                                        <td>
                                            <a href="{{route('customer.show', $customer)}}">
                                                {{$customer->nama}}
                                            </a>
                                        </td>
                                        <td>{{$customer->emails()->count()==0 ? '' : $customer->emails()->first()->email}}</td>
                                        <td>{{$customer->telepons()->count()==0 ? '' : $customer->telepons()->first()->noTelp()}}</td>
                                        <td>
                                            <a href="{{route('customer.edit', $customer)}}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pencil-alt"></i> Ubah
                                            </a>
                                            <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" href="#hapus-{{$customer->slug}}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                Hapus
                                            </a>
                                        </td>
                                        <div class="modal fade" id="hapus-{{$customer->slug}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{$customer->nama}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah {{$customer->nama}} akan dihapus?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    <form action="{{route('customer.destroy', $customer)}}" method="post">
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
                                        <td colspan="4">Data Customer masih kosong, silakan tambah terlebih dahulu</td>
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
        $('#customer').DataTable({
            "responsive" : false,
            "autoWidth" : false,
            "scrollX" : true,
        });
    });
</script>
@endsection
