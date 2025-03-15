<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Sales Order_{{ $order->invoice_no }}_{{ $order->customer->NamaLembaga }}_{{ $order->customer->NamaCustomer }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- External CSS libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/style.css') }}">
</head>

<body>
    <div class="invoice-wrapper" id="">
        <div class="invoice">
            <div class="invoice-container">
                {{-- KOP --}}
                <div class="invoice-kop">
                    <table class="invoice-kop table">
                        <td class="logo"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></td>
                        <td class="identitas-perusahaan">
                            <h2>CV.SAE GROUP</h2>
                            <p>
                                Ds. Bangsongan Kec. Kayen Kidul, 
                                Kab. Kediri, Jawa Timur, Indonesia. 64183.
                                <br>
                                <i class="fa-solid fa-phone-volume font-size-15" style="margin-right: 3px"></i>+62-858-5037-4699   
                                <i class="fa-solid fa-envelope-open-text" style="margin-left:5px; margin-right: 3px"></i>cv.saegroup@gmail.com
                                <i class="fa-solid fa-globe" style="margin-left:5px; margin-right: 3px"></i>www.saesmartgroup.com
                                <br>
                                No. NPWP : 91.200.726.7-655.000, No. PKP  : S-102/PKP/KPP.121303/2024.
                            </p>
                        </td>
                        <td class="judul-dokumen" rowspan="3">SALES ORDER</td>
                    </table>
                    <div class="hr1"></div>
                </div>


                {{-- Keterangan Dokumen --}}
                <div class="invoice-keterangan-dokumen">
                    <table class="invoice-keterangan-dokumen table">
                        <tr>
                            <td>No.</td> <td>:</td> <td><b>{{ $order->invoice_no }}</b></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td> <td>:</td> <td><b>{{ Carbon\Carbon::parse($order->order_date)->translatedformat('d F Y') }}</b></td>
                        </tr>
                    </table>
                </div>
                
                {{-- Customer --}}
                <div class="invoice-customer">
                    <table class="invoice-customer table">
                        <tr>
                            <td width="14%">Nama Customer</td> <td>:</td> <td width="37%" class="nama">{{ $order->customer->NamaCustomer }}</td>
                            <td width="14%">Nama Lembaga</td> <td>:</td> <td class="nama">{{ $order->customer->NamaLembaga }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td> <td>:</td> <td>{{ $order->customer->Jabatan }}</td>
                            <td>Telp</td> <td>:</td> <td>{{ $order->customer->TelpLembaga }}</td>
                            
                        </tr>
                        <tr>
                            <td>Telp.</td> <td>:</td> <td>{{ $order->customer->TelpCustomer }}</td>
                            <td>E-mail</td> <td>:</td> <td>{{ $order->customer->EmailLembaga }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td> <td>:</td> <td style="padding-right: 20px">{{ $order->customer->AlamatCustomer }}</td>
                            <td>Alamat</td> <td>:</td> <td>{{ $order->customer->AlamatLembaga }}</td>
                        </tr>
                    </table>
                </div>
                {{-- Detail --}}
                <div class="invoice-detail">
                    <table class="invoice-detail table">
                        <thead>
                            <th width="5%">No.</th>
                            <th width="35%">Nama Produk</th>
                            <th width="18%">Kategori</th>
                            <th width="8%">Jumlah</th>
                            <th width="14%">Harga</th>
                            <th width="18%">Total</th>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $item)
                                <tr>
                                    <td class="text-center" scope="row">{{ $loop->iteration }}</td>
                                    <td class="text-start produk">{{ $item->product->product_name }}</td>
                                    <td class="text-start">{{ $item->product->category->name }}</td>
                                    <td class="text-center">{{ number_format($item->quantity) }}</td>
                                    <td class="text-end">Rp {{ number_format($item->unitcost) }}</td>
                                    <td class="text-end">Rp {{ number_format($item->total) }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- TOTAL --}}
                <div class="invoice-total">
                    <table class="invoice-total table">
                        <tr>
                            {{-- <td rowspan="3" width="40%"><b>Catatan:</b></td> --}}
                            <td width="40%"><b>Catatan:</b></td>
                            <th width="18%" style="text-align: left">Total Produk</th>
                            <th width="8%" style="text-align: left">{{ number_format($order->total_products) }}</th>
                            <th width="14%" style="text-align: right">Subtotal</th>
                            <th width="18%">Rp {{ number_format($order->sub_total) }}</th>
                        </tr>
                        <tr>
                            <td></td>
                            {{-- <td width="48%">Batas waktu retur</td> --}}
                            {{-- <th colspan="2">Diskon</th> --}}
                            <th width="18%" style="text-align: left">Diskon</th>
                            <th colspan="2">{{ number_format($order->discount_percent, 2) }} %</th>
                            <th>Rp {{ number_format($order->discount_rp) }}</th>
                        </tr>
                        <tr>
                            <td></td>
                            <th colspan="3">Grand Total</th>
                            <th>Rp {{ number_format($order->grandtotal) }}</th>
                        </tr>
                    </table>
                </div>
                
                {{-- TANDA TANGAN --}}
                <div class="invoice-tandatangan">
                    <table class="invoice-tandatangan table">
                        <tr>
                            <td>Penerima</td>
                            <td>Sales Rep</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <th>____________________</th>
                            <th>{{ $order->customer->employee->name }}</th>
                            <th>{{ auth()->user()->employee->name }}</th>
                        </tr>
                    </table>
                </div>

                   {{-- PRINT/DOWNLOAD --}}
                   <div class="overflow-view">
                    <div class="invoice-btns">
                        <button type="button" class="invoice-btn" onclick="location.href='javascript:window.print()'">
                            <span><i class="fa-solid fa-print"></i></span>
                            <span>Cetak</span>
                    </button>
                        {{-- <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            Cetak
                        </a> --}}
                        
                    </div>

        </div>
    </div>
         

    <script src="{{ asset('assets/invoice/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/app.js') }}"></script>
</body>
</html>
