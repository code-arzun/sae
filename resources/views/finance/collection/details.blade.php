@extends('layout.main')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('collection.index') }}">Collection</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('collection.details', $collection->id) }}">Detail</a></li>
    <li class="breadcrumb-item active" aria-current="page"><b>{{ $collection->invoice_no }}</b>
@endsection


@section('container')

<div class="mb-3">
    <h4>Sales Order</h4>
    <div class="card">
        <div class="card-body row">
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Tanggal SO</label>
                <h5>{{Carbon\Carbon::parse($collection->salesorder->order_date)->translatedformat('l, d F Y') }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nomor SO</label>
                <div>
                    <a href="{{ route('so.orderDetails', $collection->salesorder->id) }}" class="badge {{ strpos($collection->salesorder->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($collection->salesorder->invoice_no, '-H') !== false ? 'bg-danger' : 
                            (strpos($collection->salesorder->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($collection->salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                        {{ $collection->salesorder->invoice_no }}
                    </a>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nama Lembaga</label>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                    href="{{ route('customers.show', $collection->salesorder->customer->id) }}">
                    <h5>{{ $collection->salesorder->customer->NamaLembaga }}</h5>
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nama Customer</label>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                    href="{{ route('customers.show', $collection->salesorder->customer->id) }}">
                    <h5>{{ $collection->salesorder->customer->NamaCustomer }}</h5>
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Jabatan</label>
                <div>
                    <span class="badge bg-secondary">{{ $collection->salesorder->customer->Jabatan }}</span>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Sales</label>
                <h5>{{ $collection->salesorder->customer->employee->name }}</h5>
            </div>
        </div>
    </div>
</div>

<h4>Detail Collection</h4>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body row">
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Tanggal Collection</label>
                    <h5>{{Carbon\Carbon::parse($collection->collection_date)->translatedformat('l, d F Y') }}</h5>
                </div>
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Nomor Collection</label>
                    <div>
                        <span class="badge {{ strpos($collection->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($collection->invoice_no, '-H') !== false ? 'bg-danger' : 
                                (strpos($collection->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($collection->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                            {{ $collection->invoice_no }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Pembayaran</label>
                    <div class="d-flex">
                        ke-<h5>{{ $collection->payment_order }}</h5>
                    </div>
                    {{-- <h5>{{ $collection->getUrutanDalamOrder() }}</h5> --}}
                </div>
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Dibayar oleh</label>
                    <h5>{{ $collection->paid_by }}</h5>
                </div>
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Metode Pembayaran</label>
                    <h5>{{ $collection->payment_method }}</h5>
                </div>
                @if ($collection->payment_method == 'Tunai')
                    <div class="col-md-4 d-flex flex-column mb-3">
                        <label class="mb-2">Diterima oleh</label>
                        <h5>{{ $collection->employee->name }}</h5>
                    </div>
                @else
                    <div class="col-md-4 d-flex flex-column mb-3">
                        <label class="mb-2">Rekening Pengirim</label>
                        <h5>{{ $collection->bank->name }} - {{ $collection->no_rek }}</h5>
                    </div>
                    <div class="col-md-4 d-flex flex-column mb-3">
                        <label class="mb-2">Dibayar ke</label>
                        <h5>{{ $collection->rekening->bank->name }} - {{ $collection->rekening->no_rek }} - {{ $collection->rekening->nama }}</h5>
                    </div>
                @endif
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Status Pembayaran</label>
                    <div>
                        <span class="badge {{ strpos($collection->payment_status, 'Belum Lunas') !== false ? 'bg-warning' : 'bg-success' }}">
                            {{ $collection->payment_status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dt-responsive table-responsive col-md-4">
        <table class="table table-hover bg-white">
            <thead>
                <tr>
                    <th width="55%">Keterangan</th>
                    <th width="15%">%</th>
                    <th width="30%">Nominal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-danger" colspan="2">Total Tagihan</th>
                    <td class="accounting discountRp">{{ number_format($collection->salesorder->sub_total) }}</td>
                </tr>
                <tr>
                    <th class="text-success" colspan="2">Jumlah diibayarkan</th>
                    <td class="accounting subtotal">{{ number_format($collection->pay) }}</td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td class="accounting discountPercent">{{ number_format($collection->discount_percent, 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->discount_rp) }}</td>
                </tr>
                <tr>
                    <td>PPh22</td>
                    <td class="accounting discountPercent">{{ number_format($collection->PPh22_percent, 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->PPh22_rp) }}</td>
                </tr>
                <tr>
                    <td>PPN</td>
                    <td class="accounting discountPercent">{{ number_format($collection->PPN_percent, 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($collection->PPN_rp) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Biaya admin</td>
                    <td class="accounting discountRp">{{ number_format($collection->admin_fee) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Biaya lainnya</td>
                    <td class="accounting discountRp">{{ number_format($collection->other_fee) }}</td>
                </tr>
                <tr>
                    <th class="text-primary" colspan="2">Total diterima</th>
                    <td class="accounting grandtotal">{{ number_format($collection->grandtotal) }}</td>
                </tr>
                <tr>
                    <th class="text-danger" colspan="2">Sisa Tagihan</th>
                    <td class="accounting discountRp">{{ number_format($collection->due) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@include('components.preview-img-form')
@endsection
