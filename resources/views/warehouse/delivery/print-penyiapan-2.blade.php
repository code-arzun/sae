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

    <!-- Google fonts -->
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> --}}

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
                            {{-- <td>Penyiapan</td>
                            <td>Tanggal Penyiapan</td> --}}
                            {{-- <td>Dicetak oleh</td> --}}
                        </tr>
                        <tr>
                            <th>{{ $order->invoice_no }}</th>
                            <th>{{ Carbon\Carbon::parse($order->order_date)->translatedformat('d F Y') }}</th>
                            {{-- <td>ke-</td> --}}
                            {{-- <td class="text-center">_______________</td>
                            <td class="text-center">_______________</td> --}}
                            <th>{{ $order->customer->NamaLembaga }}</th>
                            <th>{{ $order->customer->NamaCustomer }}</th>
                            <th>{{ $order->customer->employee->name }}</th>
                        </tr>
                    </table>
                    <div class="hr1"></div>
                </div>

                {{-- KETERANGAN DOKUMEN --}}
                <div class="penyiapan-keterangan-dokumen">
                    <table class="penyiapan-keterangan-dokumen table">
                        {{-- <tr>
                            <td width="15%">Nama Lembaga :</td><th width="20%">{{ $order->customer->NamaLembaga }}</th>
                            <td width="15%">Nama Customer :</td> <th width="20%">{{ $order->customer->NamaCustomer }}</th>
                            <td>Sales :</td><th>{{ $order->customer->employee->name }}</th>
                        </tr> --}}
                        {{-- <tr>
                            <td>Nama Lembaga</td>
                            <td>Nama Customer</td>
                            <td>Sales</td>
                        </tr>
                        <tr>
                            <th>{{ $order->customer->NamaLembaga }}</th>
                            <th>{{ $order->customer->NamaCustomer }}</th>
                            <th>{{ $order->customer->employee->name }}</th>
                        </tr> --}}
                    </table>
                </div>

                {{-- DETAIL --}}
                <div class="penyiapan-detail">
                    <table class="penyiapan-detail table">
                        <thead>
                            <th width="5%">No.</th>
                            <th width="5%"><i class="fa fa-check" aria-hidden="true"></i></th>
                            {{-- <th width="5%"><i class="fa-solid fa-badge-check"></i></th> --}}
                            {{-- <th width="7%">Lengkap</i></th> --}}
                            <th width="32%">Nama Produk</th>
                            <th width="17%">Kategori</th>
                            <th width="7%">Jumlah</th>
                            {{-- <th width="14%">Harga</th> --}}
                            <th width="10%">Tersedia</i></th>
                            <th width="10%">Kurang</i></th>
                            <th width="18%">Keterangan</i></th>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $item)
                                <tr>
                                    <td class="text-center" scope="row">{{ $loop->iteration }}</td>
                                    <td class="text-center">O</td>
                                    <td class="text-start produk">{{ $item->product->product_name }}</td>
                                    <td class="text-start">{{ $item->product->category->name }}</td>
                                    <td class="text-center">{{ number_format($item->quantity) }}</td>
                                    {{-- <td class="text-end">Rp {{ number_format($item->unitcost) }}</td> --}}
                                    <td class="text-end"></td>
                                    <td class="text-end"></td>
                                    <td class="text-end"></td>
                                </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                {{-- <td rowspan="3" width="40%"><b>Catatan:</b></td> --}}
                                <th colspan="3" class="text-start">Catatan:</td>
                                <th width="18%" style="text-align: center">Total Produk</th>
                                <th width="8%" style="text-align: center">{{ number_format($order->total_products) }}</th>
                                <td colspan="3"></td>
                                {{-- <th width="14%" style="text-align: right">Subtotal</th>
                                <th width="18%">Rp {{ number_format($order->sub_total) }}</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- TOTAL --}}
                {{-- <div class="penyiapan-total">
                    <table class="penyiapan-total table">
                        <tr> --}}
                            {{-- <td rowspan="3" width="40%"><b>Catatan:</b></td> --}}
                            {{-- <td width="40%"><b>Catatan:</b></td>
                            <th width="18%" style="text-align: left">Total Produk</th>
                            <th width="8%" style="text-align: left">{{ number_format($order->total_products) }}</th>
                            <td></td> --}}
                            {{-- <th width="14%" style="text-align: right">Subtotal</th>
                            <th width="18%">Rp {{ number_format($order->sub_total) }}</th> --}}
                        {{-- </tr>
                    </table>
                </div> --}}
                {{-- TANDA TANGAN --}}
                <div class="penyiapan-tandatangan">
                    <table class="penyiapan-tandatangan table">
                        <tr>
                            <td colspan="3" rowspan="2" class="text-start" style="vertical-align: bottom">*Beri tanda centang (<i class="fa fa-check" aria-hidden="true"></i>) jika jumlah barang sesuai pesanan.</td>
                            <th>Dicetak oleh</th>
                            <th>Disiapkan oleh</th>
                        </tr>
                        <tr>
                            {{-- <td colspan="3"></td> --}}
                            <td class="text-center">{{ auth()->user()->employee->name }}</td>
                            <td class="text-center">_______________</td>
                        </tr>
                    </table>
                </div>
            </div>

             {{-- PRINT/DOWNLOAD --}}
             <div class="overflow-view">
                <div class="invoice-btns">
                    <button type="button" class="invoice-btn" onclick="location.href='javascript:window.print()'">
                        <span><i class="fa-solid fa-print"></i></span>
                        <span>Cetak</span>
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
