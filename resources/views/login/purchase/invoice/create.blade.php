@extends('layouts.adminlte')
@section('head-link')
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>{{$purchase->no_po}}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('purchase.index')}}">Purchase Order</a></li>
                <li class="breadcrumb-item"><a href="{{route('sj.index', $purchase)}}">Invoice</a></li>
                <li class="breadcrumb-item active">Tambah</li>
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
                            <h3 class="card-title">Tambah Invoice</h3>
                        </div>
                        <form action="{{route('invoice.store', $purchase)}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_surat_jalan">Nomor Invoice</label>
                                    <input type="text" name="no_invoice" value="{{old('no_invoice', $noInvoice)}}" class="form-control" autofocus>
                                    @error('no_invoice')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Invoice</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="tanggal_invoice" value="{{old('tanggal_invoice', date('d/m/y'))}}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('tanggal_invoice')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                  <label for="jumlah">Jumlah</label>
                                  <input type="text" name="jumlah" class="form-control" value="{{old('jumlah', 0)}}">
                                  @error('jumlah')
                                  <small class="text-danger">{{$message}}</small>
                                  @enderror
                                </div>
                                <div class="form-group">
                                    <label for="signed_by">Penanda Tangan</label>
                                    <input type="text" name="signed_by" value="{{old('signed_by')}}" class="form-control">
                                    @error('signed_by')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <table class="table table-responsive-md table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nomor Surat Jalan</th>
                                            <th class="text-center">&#10003</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suratJalan as $sj)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td>{{$sj->no_surat_jalan}}</td>
                                            <td><input name="{{'list['.$loop->iteration.'][surat_jalan]'}}" type="checkbox" class="form-control form-control-sm" value="{{bcrypt($sj->id)}}"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @error('list')
                                        <tr>
                                            <td colspan="3"><small class="text-danger">{{$message}}</small></td>
                                        </tr>
                                        @enderror
                                        @if ($errors->has('list.*'))
                                        @foreach ($errors->get('list.*') as $messages)
                                        @foreach ($messages as $message)
                                        <tr>
                                            <td colspan="3"><small class="text-danger">{{$message}}</small></td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="/purchase" class="btn btn-sm btn-danger">Batal</a>
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
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- Page script -->
<script>
$(function () {
    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
})
</script>
@endsection
