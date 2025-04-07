@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('collection.index') }}">Collection</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.collection') }}">Input</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputCol.confirmation') }}">Konfirmasi</a></li>
@endsection

@section('container')

<h4>Sales Order</h4>
<div class="card">
    <div class="card-body row">
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal Collection</span>
            <h5 class="mb-0"></h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal SO</span>
            <h5 class="mb-0">{{ $salesorder->order_date }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">No. SO</span>
            <span href="{{ route('so.orderDetails', $salesorder->id) }}" class="badge {{ strpos($salesorder->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($salesorder->invoice_no, '-H') !== false ? 'bg-danger' : 
                    (strpos($salesorder->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                {{ $salesorder->invoice_no }}
            </span>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Lembaga</span>
            <h5 class="mb-0">{{ $salesorder->customer->NamaLembaga }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Customer</span>
            <h5 class="mb-0">{{ $salesorder->customer->NamaCustomer }}</h5>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Jabatan</span>
            <h5 class="mb-0">{{ $salesorder->customer->Jabatan }}</h5>
        </div>
        <div class="col-md d-flex flex-column">
            <span class="text-secondary mb-1">Sales</span>
            <h5 class="mb-0">{{ $salesorder->customer->employee->name }}</h5>
        </div>
    </div>
</div>

<div class="row">
    <h4>Detail Collection</h4>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body row">
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Dibayar oleh</label>
                    <h5>{{ $paid_by }}</h5>
                </div>
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Metode Pembayaran</label>
                    <h5>{{ $payment_method }}</h5>
                </div>
                @if ($payment_method == 'Tunai')
                    <div class="col-md-4 d-flex flex-column mb-3">
                        <label class="mb-2">Diterima oleh</label>
                        <h5>{{ $received_by->name }}</h5>
                    </div>
                    @else
                    <div class="col-md-4 d-flex flex-column mb-3">
                        <label class="mb-2">Rekening Pengirim</label>
                        <h5>{{ $bank->name }} - {{ $no_rek }}</h5>
                    </div>
                    <div class="col-md-4 d-flex flex-column mb-3">
                        <label class="mb-2">Rekening Penerima</label>
                        <h5>{{ $transfer_to->bank->name }} - {{ $transfer_to->no_rek }} - {{ $transfer_to->nama }}</h5>
                    </div>
                @endif
                <div class="col-md-4 d-flex flex-column mb-3">
                    <label class="mb-2">Status Pembayaran</label>
                    <div>
                        <span class="badge {{ strpos($payment_status, 'Belum Lunas') !== false ? 'bg-warning' : 'bg-success' }}">
                            {{ $payment_status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <table class="table bg-white table-hover">
            <thead>
                <tr>
                    <th colspan="2">Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="2" class="text-danger">Tagihan</th>
                    <td class="accounting discountRp">{{ number_format($salesorder->due) }}</td>
                </tr>
                <tr>
                    <th colspan="2" class="text-success">Nominal Pembayaran</th>
                    <td class="accounting subtotal">{{ number_format($pay) }}</td>
                </tr>
                <tr>
                    <td class="">Diskon</td>
                    <td class="accounting discountPercent">{{ number_format(($discount_percent), 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($discount_rp) }}</td>
                </tr>
                <tr>
                    <td class="">PPh22</td>
                    <td class="accounting discountPercent">{{ number_format(($PPh22_percent), 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($PPh22_rp) }}</td>
                </tr>
                <tr>
                    <td class="">PPN</td>
                    <td class="accounting discountPercent">{{ number_format(($PPN_percent), 2) }}</td>
                    <td class="accounting discountRp">{{ number_format($PPN_rp) }}</td>
                </tr>
                <tr>
                    <td class="" colspan="2">Biaya Admin</td>
                    <td class="accounting discountRp">{{ number_format($admin_fee) }}</td>
                </tr>
                <tr>
                    <td class="" colspan="2">Biaya Lainnya</td>
                    <td class="accounting discountRp">{{ number_format($other_fee) }}</td>
                </tr>
                <tr>
                    <th class="text-primary" colspan="2">Total Akhir Diterima</th>
                    <td class="accounting grandtotal">{{ number_format($grandtotal) }}</td>
                </tr>
                <tr>
                    <th class="text-danger" colspan="2">Sisa Tagihan</th>
                    <td class="accounting discountRp">{{ number_format($due) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<a href="" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#saveCollModal">Buat Collection</a>

<div id="saveCollModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="saveCollModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="text-white mb-0">Konfirmasi Collection</h3>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-2 d-flex flex-column mb-3">
                        <span class="text-secondary mb-1">Tanggal Collection</span>
                        <h5 class="mb-0"></h5>
                    </div>
                    <div class="col-md-2 d-flex flex-column mb-3">
                        <span class="text-secondary mb-1">Tanggal SO</span>
                        <h5 class="mb-0">{{ $salesorder->order_date }}</h5>
                    </div>
                    <div class="col-md-2 d-flex flex-column mb-3">
                        <span class="text-secondary mb-1">No. SO</span>
                        <span href="{{ route('so.orderDetails', $salesorder->id) }}" class="badge {{ strpos($salesorder->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($salesorder->invoice_no, '-H') !== false ? 'bg-danger' : 
                                (strpos($salesorder->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                            {{ $salesorder->invoice_no }}
                        </span>
                    </div>
                    <div class="col-md-2 d-flex flex-column mb-3">
                        <span class="text-secondary mb-1">Nama Lembaga</span>
                        <h5 class="mb-0">{{ $salesorder->customer->NamaLembaga }}</h5>
                    </div>
                    <div class="col-md-2 d-flex flex-column mb-3">
                        <span class="text-secondary mb-1">Nama Customer</span>
                        <h5 class="mb-0">{{ $salesorder->customer->NamaCustomer }}</h5>
                    </div>
                    <div class="col-md-2 d-flex flex-column">
                        <span class="text-secondary mb-1">Sales</span>
                        <h5 class="mb-0">{{ $salesorder->customer->employee->name }}</h5>
                    </div>
                </div>
                <div class="col-md-12">
                    <span class="badge bg-danger w-100">Pastikan data yang Anda masukkan sudah benar!</span>
                </div>
            </div>
            <div class="modal-footer bg-gray-100">
                <div class="invoice-btn col-md-12" data-extra-toggle="confirmation">
                    @php
                        use Illuminate\Support\Str;
        
                        $collections = [];
                            if (Str::contains($salesorder->invoice_no, ['RO', 'SOR'])) {
                                $collections[] = ['route' => 'store.ColReguler'];
                            }
                            if (Str::contains($salesorder->invoice_no, ['HO', 'SOH'])) {
                                $collections[] = ['route' => 'store.ColHet'];
                            }
                            if (Str::contains($salesorder->invoice_no, ['RS', 'SORS'])) {
                                $collections[] = ['route' => 'store.ColROnline'];
                            }
                            if (Str::contains($salesorder->invoice_no, ['HS', 'SOHS'])) {
                                $collections[] = ['route' => 'store.ColHOnline'];
                            }
                    @endphp
        
                    @foreach ($collections as $collection)
                        <form action="{{ route($collection['route']) }}" method="post" class="confirmation-form">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $salesorder->id }}">
                            <input type="hidden" name="paid_by" value="{{ $paid_by }}">
                            <input type="hidden" name="payment_method" value="{{ $payment_method }}">
                            <input type="hidden" name="payment_status" value="{{ $payment_status }}">
                            <input type="hidden" name="employee_id" value="{{ $received_by->id ?? '' }}">
                            <input type="hidden" name="bank_id" value="{{ $bank->id ?? '' }}">
                            <input type="hidden" name="no_rek" value="{{ $no_rek ?? '' }}">
                            <input type="hidden" name="rekening_id" value="{{ $transfer_to->id ?? '' }}">
                            <input type="hidden" name="due" value="{{ $due }}">
                            <input type="hidden" name="pay" value="{{ $pay }}">
                            <input type="hidden" name="discount_percent" value="{{ $discount_percent }}">
                            <input type="hidden" name="discount_rp" value="{{ $discount_rp }}">
                            <input type="hidden" name="PPh22_percent" value="{{ $PPh22_percent }}">
                            <input type="hidden" name="PPh22_rp" value="{{ $PPh22_rp }}">
                            <input type="hidden" name="PPN_percent" value="{{ $PPN_percent }}">
                            <input type="hidden" name="PPN_rp" value="{{ $PPN_rp }}">
                            <input type="hidden" name="admin_fee" value="{{ $admin_fee }}">
                            <input type="hidden" name="other_fee" value="{{ $other_fee }}">
                            <input type="hidden" name="grandtotal" value="{{ $grandtotal }}">
                            <button type="submit" class="btn btn-success me-3 w-100 confirm-button"><b>Simpan</b></button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
