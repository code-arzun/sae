<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Delivery Order_{{ $deliveries->invoice_no }}_{{ $deliveries->salesorder->customer->NamaLembaga }}_{{ $deliveries->salesorder->customer->NamaCustomer }}</title>
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
                        <td class="judul-dokumen" rowspan="3">FAKTUR PENJUALAN</td>
                    </table>
                    <div class="hr1"></div>
                </div>


                {{-- KETERANGAN DOKUMEN --}}
                <div class="invoice-keterangan-dokumen">
                    <table class="invoice-keterangan-dokumen table">
                        {{-- <td>No : <b>{{ $deliveries->invoice_no }}</b></td>
                        <td style="text-align: right">Tanggal : <b>{{ Carbon\Carbon::parse($deliveries->deliveries_date)->format('d M Y') }}</b></td> --}}
                        <tr>
                            <td>No.</td> <td>:</td> <td width="65%"><b>{{ $deliveries->invoice_no }}</b></td>
                            {{-- <td>No. SO</td> <td>:</td> <td><b>{{ $deliveries->salesorder->invoice_no }}</b></td> --}}
                        </tr>
                        <tr>
                            <td>Tanggal</td> <td>:</td> <td><b>{{ Carbon\Carbon::parse($deliveries->delivery_date)->translatedformat('d F Y') }}</b></td>
                            {{-- <td>Tanggal SO</td> <td>:</td> <td><b>{{ Carbon\Carbon::parse($deliveries->salesorder->order_date)->translatedformat('d F Y') }}</b></td> --}}
                        </tr>
                    </table>
                </div>
                
                {{-- CUSTOMER --}}
                <div class="invoice-customer">
                    <table class="invoice-customer table">
                        <tr>
                            <td width="14%">Nama Customer</td> <td>:</td> <td width="30%" class="nama">{{ $deliveries->salesorder->customer->NamaCustomer }}</td>
                            <td width="14%">Nama Lembaga</td> <td>:</td> <td class="nama">{{ $deliveries->salesorder->customer->NamaLembaga }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td> <td>:</td> <td>{{ $deliveries->salesorder->customer->Jabatan }}</td>
                            <td>Alamat</td> <td>:</td> <td rowspan="2" style="padding-right: 20px">{{ $deliveries->salesorder->customer->AlamatLembaga }}</td>
                            {{-- <td>Telp</td> <td>:</td> <td>{{ $deliveries->salesorder->customer->TelpLembaga }}</td> --}}
                            {{-- <td>Telp</td> <td>:</td> <td></td> --}}
                            
                        </tr>
                        <tr>
                            <td>Telp.</td> <td>:</td> <td>{{ $deliveries->salesorder->customer->TelpCustomer }}</td>
                        </tr>
                    </table>
                </div>
                {{-- DETAIL --}}
                <div class="invoice-detail">
                    <table class="invoice-detail table">
                        <thead>
                            <th width="5%">No.</th>
                            <th width="37%">Nama Produk</th>
                            <th width="18%">Kategori</th>
                            {{-- <th colspan="2">Jumlah</th> --}}
                            <th width="12%">Jumlah</th>
                            <th width="13%" class="text-end">Harga</th>
                            <th width="13%" class="text-end">Total</th>
                        </thead>
                        <tbody>
                            @foreach ($deliveryDetails as $item)
                                <tr>
                                    <td class="text-center" scope="row">{{ $loop->iteration }}</td>
                                    <td class="text-start produk">{{ $item->product->product_name }}</td>
                                    <td class="text-start">{{ $item->product->category->name }}</td>
                                    <td class="text-center">{{ number_format($item->quantity) }} {{ ($item->product->category->productunit->name) }}</td>
                                    {{-- <td class="text-end">{{ number_format($item->quantity) }} {{ ($item->product->category->productunit->name) }}</td> --}}
                                    {{-- <td class="text-start">{{ ($item->product->category->productunit->name) }}</td> --}}
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
                            <th width="18%" style="text-align: center">Total Produk</th>
                            <th width="10%" style="text-align: center">{{ number_format($deliveries->total_products) }}</th>
                            <th width="14%" class="text-end">Subtotal</th>
                            <th width="18%">Rp {{ number_format($deliveries->sub_total) }}</th>
                        </tr>
                        {{-- <tr>
                            <td></td>
                            <th width="18%" style="text-align: left">Diskon</th>
                            <th colspan="2">{{ number_format($deliveries->discount) }} %</th>
                            <th>Rp {{ number_format($deliveries->discount) }}</th>
                        </tr>
                        <tr>
                            <td></td>
                            <th colspan="3">Grand Total</th>
                            <th>Rp {{ number_format($deliveries->sub_total) }}</th> --}}
                        </tr>
                    </table>
                </div>
                
                {{-- TANDA TANGAN --}}
                <div class="invoice-tandatangan">
                    <table class="invoice-tandatangan table">
                        <tr>
                            <td width="40%"><i>Penerima</i></td>
                            <td width="30%"><i>Sales</i></td>
                            <td width="30%"><i>Admin {{ auth()->user()->name }}</i></td>
                        </tr>
                        <tr>
                            <td>____________________</td>
                            <td><b>{{ $deliveries->salesorder->customer->employee->name }}</b></td>
                            {{-- <td>Arzun P.</td> --}}
                            {{-- <td>____________________</td> --}}
                            <td><b>{{ auth()->user()->employee->name }}</b></td>
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
            {{-- <div class="overflow-view">
                <div class="invoice-btns">
                    <button type="button" class="invoice-btn" href="javascript:window.print()">
                            <span><i class="fa-solid fa-print"></i></span>
                            <span>Cetak</span>
                    </button>
                    
                </div>
            </div> --}}

        </div>
    </div>
         
        


    {{-- PRINT/DOWNLOAD --}}
    {{-- <div class="container mt-5 mb-5">
        <div class="invoice-btn-section clearfix d-print-none">
            <a href="javascript:window.print()" class="btn btn-lg btn-print">
                Cetak
            </a>
            <a id="invoice_download_btn" class="btn btn-lg btn-download">
                Download
            </a>
        </div>
    </div> --}}
    
    {{-- <script src="{{ asset('assets/invoice/js/script.js') }}"></script> --}}

    <script src="{{ asset('assets/invoice/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/invoice/js/app.js') }}"></script>
</body>
</html>
