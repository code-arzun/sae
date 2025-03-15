<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Label Produk_{{ $deliveries->invoice_no }}_{{ $deliveries->salesorder->customer->NamaLembaga }}_{{ $deliveries->salesorder->customer->NamaCustomer }}</title>
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
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/label/css/style.css') }}">
</head>

<body>
    <div class="label-wrapper" id="">
        <div class="label">
            <div class="label-container">
                {{-- KOP --}}
                <div class="label-kop">
                    <table class="label-kop table text-start">
                        <tr>
                            <td class="logo" rowspan="2"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></td>
                            
                            <td>ID Pesanan</td>
                            <td>Tanggal Kirim</td>
                            <td>Kurir</td>
                        </tr>
                        <tr>
                            
                            <th>{{ $deliveries->invoice_no }}</th>
                            <td></td>
                        </tr>
                    </table>
                    <div class="hr1"></div>
                </div>

                {{-- Customer DOKUMEN --}}
                <div class="label-customer">
                    <table class="label-customer table">
                        <tr>
                            <td>Dikirim oleh
                                <h2>CV. SAE GROUP</h2>
                            </td>
                            <td>Kepada
                                <h2>{{ $deliveries->salesorder->customer->NamaLembaga }}</h2>
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>CV. SAE GROUP</th>
                            <th>{{ $deliveries->salesorder->customer->NamaLembaga }}</th>
                        </tr> --}}
                    </table>
                </div>

                {{-- DETAIL --}}
                <div class="label-detail">
                    <table class="label-detail table">
                        <thead>
                            <th width="10%">No.</th>
                            <th width="80%">Nama Produk</th>
                            {{-- <th width="50%">Nama Produk</th> --}}
                            {{-- <th width="25%">Kategori</th> --}}
                            <th width="10%">Jumlah</th>
                        </thead>
                        <tbody>
                            @foreach ($deliveryDetails as $item)
                                <tr>
                                    <td class="text-center" scope="row">{{ $loop->iteration }}</td>
                                    <td class="text-start produk">
                                        <h2>{{ $item->product->product_name }} </h2>
                                        {{-- <br>  --}}
                                        {{-- <p> --}}
                                            {{ $item->product->category->name }}
                                        {{-- </p> --}}
                                    </td>
                                    {{-- <td>{{ $item->product->category->name }}</td> --}}
                                    <td class="text-center"></td>
                                </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align: right" colspan="2">Total Produk</th>
                                <td width="8%" style="text-align: center"></d>
                            </tr>
                        </tfoot>
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
                <div class="label-btn-section clearfix d-print-none">
                    <a href="javascript:window.print()" class="btn btn-lg btn-print">
                        Cetak
                    </a>
                    <a id="invoice_download_btn" class="btn btn-lg btn-download">
                        Download
                    </a>
                </div>
            </div> --}}
               
            </div>
        </div>
    </div>
            
        



    <script src="{{ asset('assets/label/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/label/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/label/js/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/label/js/app.js') }}"></script>
</body>
</html>
