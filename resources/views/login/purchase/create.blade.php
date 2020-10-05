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
            <h1>Purchase Order</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/purchase">Purchase Order</a></li>
                <li class="breadcrumb-item active">Tambah PO</li>
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
                            <h3 class="card-title">Tambah Purchase Order</h3>
                        </div>
                        <form action="{{route('purchase.store')}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="customer">Customer</label>
                                    <select class="form-control select2bs4" name="customer" id="customer" style="width: 100%;">
                                        @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}" @if(old('customer') == $customer->id) selected @endif>{{$customer->nama_customer}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="no_po">Nomor Purchase Order</label>
                                    <input value="{{old('no_po')}}" type="text" name="no_po" id="no_po" class="form-control" placeholder="Silakan isi Nomor Purchase Order">
                                    @error('no_po')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal PO</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="tanggal_po" value="{{old('tanggal_po', date('d/m/y'))}}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('tanggal_po')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengiriman</label>
                                    <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                        <input name="tanggal_kirim" value="{{old('tanggal_kirim', date('d/m/y'))}}" type="text" class="form-control datetimepicker-input" data-target="#reservationdate2"/>
                                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('tanggal_kirim')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="top">Term of Payment</label>
                                    <input value="{{old('top')}}" type="text" name="top" id="top" class="form-control" placeholder="Silakan isi Term Pembayaran, contoh: 1 bulan setelah invoice diterima, cash on delivery, dp 30%">
                                    @error('top')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="down_payment">Down Payment(dp)</label>
                                    <input type="number" name="down_payment" id="down_payment" class="form-control" min="0" step="0.01" value="{{old('harga', 0)}}">
                                    @error('down_payment')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-inline mb-3">
                                    <div class="form-group">
                                        <label class="mr-2">PPN 10%</label>
                                        <div class="form-check mr-2">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="ppn" value="Ya" {{old('ppn')==='Ya' || empty(old('ppn')) ? 'checked' : ''}}>
                                            Ya
                                          </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="ppn" value="Tidak" {{old('ppn')==='Tidak' ? 'checked' : ''}}>
                                            Tidak
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <label for="nama_produk" class="mr-2">Nama Produk</label>
                                        <select class="form-control mr-2" id="sproduk">
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->nama_produk}}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="tambahProduk()">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-responsive-md table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="produk"></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" id="total" class="text-right font-weight-bold"></td>
                                            <td></td>
                                        </tr>
                                        @error('product')
                                        <tr>
                                            <td colspan="5"><small class="text-danger">{{$message}}</small></td>
                                        </tr>
                                        @enderror
                                        @if ($errors->has('product.*'))
                                        @foreach ($errors->get('product.*') as $messages)
                                        @foreach ($messages as $message)
                                        <tr>
                                            <td colspan="5"><small class="text-danger">{{$message}}</small></td>
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
    $('#reservationdate2').datetimepicker({
        //format: 'L'
        format: 'DD/MM/YYYY'
    });

    $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
})

var x=0;
function tambahProduk() {
    var sproduk = document.getElementById('sproduk');

    var getProduk = sproduk.options[sproduk.selectedIndex].value;
    var listProduk = JSON.parse('<?php echo json_encode($products); ?>');

    var produk = cari(getProduk, listProduk);
    $('#produk').append(
        '<tr id="'+x+'">'+
            '<td><input type="hidden" name="product['+x+'][produk]" value="'+produk.id+'">'+produk.nama_produk+'</td>'+
            '<td style="width: 100px;"><input class="form-control" value="1" id="jumlah'+x+'" onchange="subnTotal(this)" type="number" min="0" step="0.01" name="product['+x+'][jumlah]"></td>'+
            '<td style="width: 150px;"><input class="form-control" id="harga'+x+'" onchange="subnTotal(this)" type="number" min="0" step="0.01" name="product['+x+'][harga]" value="'+produk.harga+'"></td>'+
            '<td id="subtotal'+x+'" class="text-right">'+(produk.harga)+'</td>'+
            '<td><button type="button" class="btn btn-sm btn-danger" onclick="hapus(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
        '</tr>'
    );

    x++;
}

function cari(id, data) {
    for (var i = 0; i < data.length; i++) {
        if (data[i].id == id)
            return data[i];
    }
    return 0;
}

function subtotal(sub) {
    var str = sub.id;
    var cek = str.match(/(\d+)/);
    var subtotal = document.getElementById('subtotal'+cek[0]);
    var harga = document.getElementById('harga'+cek[0]);
    var jumlah = document.getElementById('jumlah'+cek[0]);

    subtotal.innerHTML = "Rp. " + (parseFloat(harga.value) * parseFloat(jumlah.value)).toLocaleString('id-ID');
}

function hapus(data) {
    data.parentElement.parentElement.remove();
}

function subnTotal(data) {
    subtotal(data);
    getTotal(data);
}

function getTotal(data) {
    var tparent = data.parentElement.parentElement.parentElement;
    var datachild = tparent.children;
    var nchild = datachild.length;
    var total = 0;

    for (var i=0;i<nchild;i++) {
        var jumlah = datachild[i].children[1].children[0].value;
        var harga = datachild[i].children[2].children[0].value

        total += (parseFloat(jumlah)*parseFloat(harga));
    }

    var eltotal = document.getElementById('total');
    eltotal.innerHTML = "Rp. " + total.toLocaleString('id-ID');
}
</script>
@endsection
