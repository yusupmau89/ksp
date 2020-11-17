<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        @page {
            margin-top: 2.5cm;
        }
        body{
            margin: 0 1cm 1cm 1cm;
        }
        .header {
            position: fixed;
            top: -2.5cm;
            display: inline-block;
            vertical-align: middle;
        }
        .logo {
            display: inline-block;
            margin-top: 12px;
            width: 2cm;
            vertical-align: middle;
        }
        p {
            display: inline-block;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            vertical-align: middle;
            font-size: 16pt;
        }
        p.perusahaan {
            font-weight: bold;
            color: orangered;
        }
        p.tanggal {
            margin-left: 50px;
            color: black;
            font-size: 16pt;
        }
        .invoice {
            margin-top: 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .alamat {
            margin-top: 20px;
        }
        .dari, .kepada {
            display: inline-block;
            width: 49%;
            border: 1px solid black;
        }
        table.invoice-table {
            border-collapse: collapse;
        }
        table.invoice-table>thead, table.invoice-table>tbody,
        table.invoice-table>thead>tr, table.invoice-table>thead>tr>th,
        table.invoice-table>tbody>tr, table.invoice-table>tbody>tr>td,
        table.invoice-table>tfoot>tr, table.invoice-table>tfoot>tr>td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        table.invoice-table>tfoot>tr>td.no-border{
            border: none;
        }
        .invoice-list {
            margin-top: 10px;
        }
        .footer {
            margin-top: 2cm;
        }
        .footer>table {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{asset('img/Logo KSP.jpg')}}" class="logo">
    <p class="perusahaan">CV Karya Sekeluarga Putra</p>
    <p class="tanggal">Citeureup, {{date('d/m/Y', strtotime($invoice->tanggal_invoice))}}</p>
</div>
<div class="invoice">
    INVOICE : {{$invoice->no_invoice}}
</div>
<div class="alamat">
    <div class="dari">
        <table>
            <tr>
                <td>From:</td>
            </tr>
            <tr>
                <td>CV Karya Sekeluarga Putra</td>
            </tr>
            <tr><td>Ds. Tarikolot Jl. Raya Sabilillah RT.04 RW.01</td></tr>
        </table>
    </div>
    <div class="kepada">
        <table>
            <tr>
                <td>Bill To:</td>
            </tr>
            <tr>
                <td>{{$invoice->purchase->customer->nama_customer}}</td>
            </tr>
            <tr><td>{{$invoice->purchase->customer->alamat_penagihan}}</td></tr>
        </table>
    </div>
</div>
<div class="purchase">
    <table class="po">
        <tr>
            <td>Nomor PO</td>
            <td>:</td>
            <td>{{$invoice->purchase->no_po}}</td>
        </tr>
        <tr>
            <td>Tanggal PO</td>
            <td>:</td>
            <td>{{date('d/m/Y', strtotime($invoice->purchase->tanggal_po))}}</td>
        </tr>
    </table>
</div>
<div class="invoice-list">
    <table class="invoice-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @php
            $nomor=1;
        @endphp
        @foreach ($products as $list)
        @if ($list->jumlah - $list->retur>0)
        <tr>
            <td class="text-center">{{$nomor}}</td>
            <td>{{$list->kode_produk}}</td>
            <td>{{$list->nama_produk}}</td>
            <td class="text-center">{{$list->jumlah-$list->retur}} {{$list->satuan_unit}}</td>
            <td>Rp. {{number_format($list->harga, 2, ',', '.')}}</td>
            <td>Rp. {{number_format($list->subtotal, 2, ',', '.')}}</td>
        </tr>
        @php
            $nomor++;
        @endphp
        @endif
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right no-border">Total &nbsp;&nbsp;</td>
                <td colspan="2" class="text-right">Rp. {{number_format($products->sum('subtotal'),2,',','.')}}</td>
            </tr>
            @if ($invoice->purchase->ppn == 'Ya')
            <tr>
                <td colspan="4" class="text-right no-border">PPN 10% &nbsp;&nbsp;</td>
                <td colspan="2" class="text-right">Rp. {{number_format(floor($products->sum('subtotal')*0.1),2,',','.')}}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right no-border"><strong>Grand Total &nbsp;&nbsp;</strong></td>
                <td colspan="2" class="text-right"><big><strong>Rp. {{number_format(floor($invoice->jumlah),2,',','.')}}</strong></big></td>
            </tr>
            @endif
        </tfoot>
    </table>
</div>
<div class="footer">
    <table style="width: 100%;">
        <tr>
            <td style="width: 35%;">&nbsp;</td>
            <td style="width: 35%;">&nbsp;</td>
            <td style="width: 30%;" class="text-center">Hormat Kami,</td>
        </tr>
        <tr>
            <td colspan="3" style="height: 2.5cm;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td class="text-center">{{$invoice->signed_by}}</td>
        </tr>
    </table>
</div>
</body>
</html>
