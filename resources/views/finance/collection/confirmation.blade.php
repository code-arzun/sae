@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('collection.index') }}">Collection</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.collection') }}">Input</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('inputCol.confirmation') }}">Konfirmasi</a></li>
@endsection

@section('container')

<div class="card">
    <div class="card-body row">
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal Collection</span>
            <h4 class="mb-0"></h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Tanggal SO</span>
            <h4 class="mb-0">{{ $salesorder->order_date }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">No. SO</span>
            <h4 class="mb-0">{{ $salesorder->invoice_no }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Lembaga</span>
            <h4 class="mb-0">{{ $salesorder->customer->NamaLembaga }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Nama Customer</span>
            <h4 class="mb-0">{{ $salesorder->customer->NamaCustomer }}</h4>
        </div>
        <div class="col-md d-flex flex-column mb-3">
            <span class="text-secondary mb-1">Jabatan</span>
            <h4 class="mb-0">{{ $salesorder->customer->Jabatan }}</h4>
        </div>
        <div class="col-md d-flex flex-column">
            <span class="text-secondary mb-1">Sales</span>
            <h4 class="mb-0">{{ $salesorder->customer->employee->name }}</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-responsive table-hover">
            <thead>
                <tr>
                    <th colspan="2">Detail Collection</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="25%">Dibayar Oleh</td>
                    <th width="75%">{{ $paid_by }}</th>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <th>{{ $payment_method }}</th>
                </tr>
                @if ($payment_method === 'Tunai')
                    <tr>
                        <td>Diterima oleh</td>
                        <th>{{ $received_by->name }}</th>
                    </tr>
                    @else
                    <tr>
                        <td>Rekening Pengirim</td>
                        <th>{{ $bank->name }} - {{  $no_rek }}</th>
                    </tr>
                    <tr>
                        <td>Rekening Penerima</td>
                        <th>{{ $transfer_to->bank->name }} - {{  $transfer_to->no_rek }}</th>
                    </tr>
                @endif
                <tr>
                    <td>Total Tagihan</td>
                    <td class="accounting discountRp">{{ number_format($salesorder->due) }}</td>
                </tr>
                <tr>
                    <td>Telah dibayar</td>
                    <td class="accounting subtotal">{{ number_format($salesorder->paid) }}</td>
                </tr>
                <tr>
                    <td>Sisa Tagihan</td>
                    <td class="accounting grandtotal">{{ number_format($salesorder->due - $salesorder->paid) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table text-end table-hover">
            <thead>
                <tr>
                    <th colspan="2">Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="text-left">Tagihan</td>
                    <td><span class="badge bg-danger">Rp {{ number_format($salesorder->due) }}</span></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-left">Nominal Pembayaran</td>
                    <td><span class="badge bg-success">Rp {{ number_format($pay) }}</span></td>
                </tr>
                <tr>
                    <td class="text-left">Diskon</td>
                    <td class="font-weight-bold text-secondary">{{ number_format(($discount_percent), 2) }} %</td>
                    <td class="font-weight-bold text-secondary">Rp {{ number_format($discount_rp) }}</td>
                </tr>
                <tr>
                    <td class="text-left">PPh22</td>
                    <td class="font-weight-bold text-secondary">{{ number_format(($PPh22_percent), 2) }} %</td>
                    <td class="font-weight-bold text-secondary">Rp {{ number_format($PPh22_rp) }}</td>
                </tr>
                <tr>
                    <td class="text-left">PPN</td>
                    <td class="font-weight-bold text-secondary">{{ number_format(($PPN_percent), 2) }} %</td>
                    <td class="font-weight-bold text-secondary">Rp {{ number_format($PPN_rp) }}</td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">Biaya Admin</td>
                    <td class="font-weight-bold text-secondary"><b>Rp {{ number_format($admin_fee) }}</b></td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">Biaya Lainnya</td>
                    <td class="font-weight-bold text-secondary"><b>Rp {{ number_format($other_fee) }}</b></td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">Total Akhir Diterima</td>
                    <td class="font-weight-bold text-secondary"><span class="badge bg-primary">Rp {{ number_format($grandtotal) }}</span></td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">Sisa Tagihan</td>
                    <td lass="font-weight-bold text-danger"><b>Rp {{ number_format($due) }}</b></td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">Status Pembayaran</td>
                    <td class="font-weight-bold text-secondary">
                        <span class="badge {{ strpos($payment_status, 'Belum Lunas')  !== false ? 'badge-danger' : 'badge-success' }}">
                            {{ $payment_status }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card-footer d-flex justify-content-end">
<div class="invoice-btn d-flex" data-extra-toggle="confirmation">
    {{-- @php
        $collections = [
            ['route' => 'store.ColReguler', 'label' => 'COR'],
            ['route' => 'store.ColHet', 'label' => 'COH'],
            ['route' => 'store.ColROnline', 'label' => 'CORS'],
            ['route' => 'store.ColHOnline', 'label' => 'COHS']
        ];
    @endphp --}}
    
    @php
    use Illuminate\Support\Str;

    $collections = [];
        if (Str::contains($salesorder->invoice_no, 'RO')) {
            $collections[] = ['route' => 'store.ColReguler', 'label' => 'R-Offline'];
        }
        if (Str::contains($salesorder->invoice_no, 'HO')) {
            $collections[] = ['route' => 'store.ColHet', 'label' => 'H-Offline'];
        }
        if (Str::contains($salesorder->invoice_no, 'RS')) {
            $collections[] = ['route' => 'store.ColROnline', 'label' => 'R-Online'];
        }
        if (Str::contains($salesorder->invoice_no, 'HS')) {
            $collections[] = ['route' => 'store.ColHOnline', 'label' => 'H-Online'];
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
            <button type="submit" class="btn bg-success me-3 confirm-button"><b>{{ $collection['label'] }}</b></button>
        </form>
    @endforeach
</div>
</div>

@endsection
