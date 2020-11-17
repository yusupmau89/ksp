<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @page{
            margin-top: 4cm;
            margin-bottom: 2.5cm;
            size: 9.5in 11in;
        }
        body{
            display: block;
            margin: 0 1cm 1cm 1cm;
        }
        img{
            height: 2cm;
            width: 2cm;
        }
        table.logo
        {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            border-bottom: 5px double black;
            margin-bottom: 1rem;
            width: 100%;
        }
        td.image-logo{
            height: 2cm;
            width: 2cm;
            text-align: center;
            margin-right: 0;
        }
        .large-bold{
            font-size: 24pt;
            font-weight: bold;
        }
        td.moto{
            font-size: 10pt;
            font-style: italic;
        }
        td.alamat{
            font-size: 8pt;
        }
        p{
            margin-top: 0;
            margin-bottom: 10px;
        }
        .kanan{
            text-align: right;
        }
        table.address{
            width: 50%;
        }
        .row{
            margin-bottom: 1cm;
            margin-top: 0cm;
        }
        .col{
            display: inline-block;
        }
        table.surat{
            width: 100%;
            border-collapse: collapse;
            margin-top: -1.5cm;
        }
        tr{
            page-break-inside: avoid;
        }
        table.surat, table.surat > thead, table.surat > tbody, table.surat > tr, table.surat > td,
        table.surat>thead>tr, table.surat>thead>tr>th,
        table.surat>tbody>tr, table.surat>tbody>tr>td,
        {
            border: 1px solid black;
        }
        .center{
            text-align: center;
        }
        .footer{
            page-break-inside: avoid;
            position: fixed;
            bottom: 2.5cm;
            left: 1cm;
            right: -1cm;
            margin: 0;
        }
        .header{
            position: fixed;
            top: -3.5cm;
            left: 1cm;
            right: 1cm;
            height: 3cm;
        }
        .body{
            margin-top: 0;
        }
        table.ttd{
            width: 100%;
            text-align: center;
        }
        .kosong{
            height: 2.5cm;
        }
        table.ttd>tbody>tr>td{
            width: 7cm;
        }
        .pad {
            padding-left: 3cm;
            font-size: small;
        }
        .b-bot{
            text-decoration: underline;
        }
    </style>
    <title>Surat Jalan</title>
</head>
<body>
<div class="header">
    <table class="logo">
        <tr>
            <td class="image-logo" rowspan="2"><img src="{{asset('img/Logo KSP.jpg')}}"></td>
            <td class="large-bold">CV Karya Sekeluarga Putra</td>
        </tr>
        <tr>
            <td class="moto">Metal Work, Manufacturing, Industrial Supplier, Stainless Steel Fabrication, Steel Construction Tank</td>
        </tr>
        <tr>
            <td colspan="2" class="alamat">Jl. Raya Sabilillah Ds. Tarikolot RT.04 RW.01 Kec. Citeureup Kab. Bogor, 16810</td>
        </tr>
        <tr>
            <td colspan="2" class="alamat">No. Telp: (021) 87942141, email: karyasekeluarga.putra@yahoo.com</td>
        </tr>
    </table>
</div>
<div class="body">
    <div class="row">
        <p class="large-bold center b-bot">Surat Jalan</p>
        <p class="kanan">Citeureup, {{date('d F Y',strtotime($sj->tanggal_surat_jalan))}}</p>
    </div>
    <div class="col">
        <table class="address">
            <tr>
                <td>No. Surat Jalan</td>
                <td>:</td>
                <td>{{$sj->no_surat_jalan}}</td>
            </tr>
            <tr>
                <td>Nomor PO</td>
                <td>:</td>
                <td>{{$sj->purchase->nomor_po}}</td>
            </tr>
            <tr>
                <td>Tanggal PO</td>
                <td>:</td>
                <td>{{date('d/m/Y', strtotime($sj->purchase->tanggal_po))}}</td>
            </tr>
        </table>
    </div>
    <div class="col">
        <table class="address pad">
            <tr><td>Kepada Yth.</td></tr>
            <tr><td>{{$sj->purchase->customer->nama}}</td></tr>
            <tr><td>{{$sj->purchase->customer->alamats()->where('ref_alamat_id',1)->first()->nama_jalan}}</td></tr>
        </table>
    </div>
    <table class="surat">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sj->lists as $item)
            <tr>
                <td class="center">{{$loop->iteration}}</td>
                <td>{{$item->purchaseList->product->kode_produk}}</td>
                <td>{{$item->purchaseList->product->nama_produk}}</td>
                <td class="center">{{$item->jumlah/100}} {{$item->purchaseList->product->satuan_unit}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <table class="ttd">
            <tbody>
            <tr>
                <td>Penerima,</td>
                <td>Hormat Kami,</td>
            </tr>
            <tr><td class="kosong">&nbsp;</td><td class="kosong">&nbsp;</td></tr>
            <tr>
                <td>(______________________)</td>
                <td>( {{$sj->signed_by}} )</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
