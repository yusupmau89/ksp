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
            <h1>Kategori</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Kategori</li>
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
                                Kategori
                            </h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                            @endif
                            @if ($errors->any())
                            <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                            </ul>
                            @endif
                            <form class="form-inline mb-3" action="{{route('kategori.store')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <input type="text" name="kategori" class="form-control form-control-sm ml-2" placeholder="Kategori">
                                </div>
                                <div class="form-group mx-2">
                                  <label for="deskripsi">Deskripsi</label>
                                  <input type="text" class="form-control form-control-sm ml-2" name="deskripsi" placeholder="Deskripsi">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary mx-1"><i class="fas fa-save    "></i> Tambah</button>
                            </form>
                            <table class="table table-bordered table-striped" id="kategori">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategori as $item)
                                    <tr>
                                        <td>{{$item->kategori}}</td>
                                        <td>{{$item->deskripsi}}</td>
                                        <td>
                                            <a href="#edit-{{$item->id}}" data-toggle="modal" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pencil-alt"></i> Ubah
                                            </a>
                                            <a type="button" class="btn btn-sm btn-danger" data-toggle="modal" href="#hapus-{{$item->id}}">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                            </a>
                                        </td>
                                        <div class="modal fade" id="edit-{{$item->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{$item->kategori}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('kategori.update', $item)}}" method="post">
                                                    @csrf @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="kategori">Kategori</label>
                                                        <input type="text" name="kategori" class="form-control" value="{{$item->kategori}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deskripsi">Deskripsi</label>
                                                        <input type="text" name="deskripsi" class="form-control" value="{{$item->deskripsi}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="parent_id">Subkategori dari</label>
                                                        <select class="form-control" name="parent_id">
                                                            <option value="">-</option>
                                                        @foreach ($pilih as $pil)
                                                        @if ($pil->id!=$item->id)
                                                            <option value="{{$pil->id}}" {{$item->parent_id==$pil->id ? 'selected' : ''}}>{{$pil->kategori}}</option>
                                                        @endif
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                                </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                        <div class="modal fade" id="hapus-{{$item->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{$item->kategori}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah {{$item->kategori}} akan dihapus?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    <form action="{{route('kategori.destroy', $item)}}" method="post">
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
                                        <td colspan="4">Kategori masih kosong, silakan tambah terlebih dahulu</td>
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
        $('#kategori').DataTable({
            "responsive" : false,
            "autoWidth" : false,
            "scrollX" : true,
        });
    });
</script>
@endsection
