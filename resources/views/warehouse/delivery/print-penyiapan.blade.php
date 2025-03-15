<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Penyiapan Produk - {{ $order->invoice_no }} - {{ $order->customer->NamaLembaga }} - {{ $order->customer->NamaCustomer }} | {{ $order->customer->employee->name }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- External CSS libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/penyiapan/css/style.css') }}">
</head>

<body>
    <div class="penyiapan-wrapper" id="">
        <div class="penyiapan">
            <div class="penyiapan-container">
                {{-- KOP --}}
                <div class="penyiapan-kop">
                    <table class="penyiapan-kop table text-start">
                        <tr>
                            <td class="logo" rowspan="2"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></td>
                            <td class="judul-dokumen text-start" rowspan="2">
                                PENYIAPAN PRODUK </td>
                            <td>No.</td>
                            <td>Tanggal SO</td>
                            <td>Nama Lembaga</td>
                            <td>Nama Customer</td>
                            <td>Sales</td>
                            <td>Dicetak oleh</td>
                        </tr>
                        <tr>
                            <th>{{ $order->invoice_no }}</th>
                            <th>{{ Carbon\Carbon::parse($order->order_date)->translatedformat('d F Y') }}</th>
                            <th>{{ $order->customer->NamaLembaga }}</th>
                            <th>{{ $order->customer->NamaCustomer }}</th>
                            <th>{{ $order->customer->employee->name }}</th>
                            <th>{{ auth()->user()->employee->name }}</th>
                        </tr>
                    </table>
                    {{-- <div class="hr1"></div> --}}
                </div>

                {{-- KETERANGAN DOKUMEN --}}
                <div class="penyiapan-keterangan-dokumen">
                    <table class="penyiapan-keterangan-dokumen table">
                         <tr class="border-top">
                            <td class="border-left" width="2%">Penyiapan
                            </td>
                            <td width="15%">Tanggal</td>
                            <td width="11%">Disiapkan oleh</td>
                            <td width="2%" class="border-left">Penyiapan
                            </td>
                            <td width="15%">Tanggal</td>
                            <td width="11%">Disiapkan oleh</td>
                            <td width="2%" class="border-left">Penyiapan
                            </td>
                            <td width="15%">Tanggal</td>
                            <td class="border-right" width="11%">Disiapkan oleh</td>
                        </tr>
                         <tr class="border-bottom">
                            <td class="border-left">ke-</td>
                            <td class="text-center">
                            </td>
                            <td></td>
                            <td class="border-left">ke-</td>
                            <td class="text-center">
                            </td>
                            <td></td>
                            <td class="border-left">ke-</td>
                            <td class="text-center">
                            </td>
                            <td class="border-right"></td>
                        </tr>
                    </table>
                </div>

                {{-- DETAIL --}}
                <div class="penyiapan-detail">
                    <table class="penyiapan-detail table">
                        <thead>
                            <th width="2%">No.</th>
                            <th width="26%">Nama Produk</th>
                            <th width="11%">Kategori</th>
                            <th width="6%">Harga</th>
                            <th width="3%">Jml</th>
                            <th width="4%" class="border-left"><i class="fa fa-check" aria-hidden="true"></i></th>
                            <th width="4%">-</th>
                            <th width="7%">Ket.</th>
                            <th width="4%"><i class="fa fa-check" aria-hidden="true"></i></th>
                            <th width="4%">-</th>
                            <th width="7%">Ket.</th>
                            <th width="4%"><i class="fa fa-check" aria-hidden="true"></i></th>
                            <th width="4%">-</th>
                            <th width="7%">Ket.</th>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $item)
                                <tr>
                                    <td class="text-center border-left" scope="row" width="2%">{{ $loop->iteration }}</td>
                                    <td class="text-start"><b>{{ $item->product->product_name }}</b></td>
                                    <td>{{ $item->product->category->name }}</td>
                                    <td class="text-end">Rp {{ number_format($item->unitcost) }}</td>
                                    <td class="text-center produk">{{ number_format($item->quantity) }}</td>
                                    <td class="text-end border-left" colspan="3"></td>
                                    <td class="text-end border-left" colspan="3"></td>
                                    <td class="text-end border-left border-right" colspan="3"></td>
                                </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-left">
                                <td width="18%" colspan="2" class="text-start produk">Catatan:</td>
                                <td colspan="2" class="text-end produk">Total Produk</td>
                                <td class="text-center produk border-right">{{ number_format($order->total_products) }}</td>
                                <td colspan="3" class="border-right"></td>
                                <td colspan="3" class="border-right"></td>
                                <td colspan="3" class="border-right"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

             {{-- PRINT/DOWNLOAD --}}
             <div class="overflow-view">
                <div class="penyiapan-btns">
                    <button type="button" class="penyiapan-btn" onclick="location.href='javascript:window.print()'">
                        <i class="fa-solid fa-print me-3"></i>
                       Cetak
                </button>

        </div>
    </div>
            
        
                </div>
            </div>



    <script src="{{ asset('assets/penyiapan/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/penyiapan/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/penyiapan/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/penyiapan/js/app.js') }}"></script>
</body>
</html>
