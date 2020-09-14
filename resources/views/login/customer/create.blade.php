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
                <li class="breadcrumb-item active">Tambah Customer</li>
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
                            <h3 class="card-title">Tambah Customer</h3>
                        </div>
                        <form action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_customer">Nama Customer</label>
                                    <input value="{{old('nama_customer')}}" type="text" name="nama_customer" id="nama_customer" class="form-control" placeholder="Silakan isi Nama Customer" autofocus>
                                    @error('nama_customer')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-inline mb-3">
                                    <div class="form-group">
                                        <label class="mr-2">NPWP</label>
                                        <input size="2" value="{{old('npwp.0')}}" type="text" name="npwp[]"  class="form-control mr-2" pattern="^[0-9]{2}$">
                                        <input type="hidden" class="form-control" name="npwp[]" value=".">
                                        <label class="mr-2">.</label>
                                        <input size="3" value="{{old('npwp.2')}}" type="text" name="npwp[]"  class="form-control mr-2" pattern="^[0-9]{3}$">
                                        <input type="hidden" class="form-control" name="npwp[]" value=".">
                                        <label class="mr-2">.</label>
                                        <input size="3" value="{{old('npwp.4')}}" type="text" name="npwp[]"  class="form-control mr-2" pattern="^[0-9]{3}$">
                                        <input type="hidden" class="form-control" name="npwp[]" value=".">
                                        <label class="mr-2">.</label>
                                        <input size="1" value="{{old('npwp.6')}}" type="text" name="npwp[]"  class="form-control mr-2" pattern="^[0-9]{1}$">
                                        <input type="hidden" class="form-control" name="npwp[]" value="-">
                                        <label class="mr-2">-</label>
                                        <input size="3" value="{{old('npwp.8')}}" type="text" name="npwp[]"  class="form-control mr-2" pattern="^[0-9]{3}$">
                                        <input type="hidden" class="form-control" name="npwp[]" value=".">
                                        <label class="mr-2">.</label>
                                        <input size="3" value="{{old('npwp.10')}}" type="text" name="npwp[]"  class="form-control" pattern="^[0-9]{3}$">
                                        @error('npwp.*')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_pengiriman">Alamat Pengiriman</label>
                                    <textarea class="form-control" name="alamat_pengiriman" id="alamat_pengiriman" rows="3" style="resize: none;" placeholder="Silakan Isi Alamat Pengiriman">{{old('alamat_pengiriman')}}</textarea>
                                    @error('alamat_pengiriman')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat_penagihan">Alamat Penagihan <small class="text-muted">*) Kosongkan bila sama dengan alamat pengiriman</small></label>
                                    <textarea style="resize: none;" class="form-control" name="alamat_penagiihan" id="alamat_penagihan" rows="3">{{old('alamat_penagihan')}}</textarea>
                                    @error('alamat_penagihan')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Alamat Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Silakan Isi Email">
                                    @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_telepon">Nomor Telepon</label>
                                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{old('no_telepon')}}" pattern="^[0-9]{10,17}$" placeholder="Silakan Isi No Telepon">
                                    @error('no_telepon')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="/customer" class="btn btn-sm btn-danger">Batal</a>
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
