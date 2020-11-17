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
                <li class="breadcrumb-item active">Tambah Produk</li>
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
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Barang / Jasa</h3>
                        </div>
                        <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kode_produk">Kode Produk</label>
                                    <input value="{{old('kode_produk')}}" type="text" name="kode_produk" id="kode_produk" class="form-control" placeholder="Silakan isi Kode Produk" autofocus>
                                    @error('kode_produk')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input value="{{old('nama_produk')}}" type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Silakan isi Nama Produk">
                                    @error('nama_produk')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Jenis Produk</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="jenis_produk" value="Barang" checked>
                                            Barang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="jenis_produk" value="Jasa">
                                            Jasa
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select class="form-control" name="kategori">
                                    @foreach ($kategori as $item)
                                        <option value="{{$item->id}}" {{old('kategori')==$item->id?'selected':''}}>{{$item->kategori}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="satuan_unit">Satuan Unit</label>
                                    <input value="{{old('satuan_unit')}}" type="text" name="satuan_unit" id="satuan_unit" class="form-control" placeholder="Silakan isi Satuan Unit, contoh: pcs, kg, ton, set">
                                    @error('satuan_unit')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" min="0" step="0.01" value="{{old('harga', 0)}}">
                                    @error('harga')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="drawing">Drawing <small class="text-muted">*) Kosongkan bila tidak ada drawing</small></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="drawing" name="drawing">
                                            <label class="custom-file-label" for="drawing">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                    @error('drawing')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="/product" class="btn btn-sm btn-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    </section>
</div>
@endsection
@section('scripts')
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
</script>
@endsection
