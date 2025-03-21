@extends('layout.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <div class="iq-header-title">
                        <a href="{{ url()->previous() }}" class="badge bg-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i class="fa fa-arrow-left mb-1 mt-1"></i></a>
                    </div>
                    <div class="iq-header-title">
                        <h3 class="card-title mb-0"><i class="fa fa-money me-3"></i>Collection</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                                <div class="col-sm me-3">
                                    <table class="table text-end table-hover">
                                        <thead >
                                            <tr>
                                                <th colspan="3">Detail Collection 
                                                    {{-- <a class="badge 
                                                        {{ strpos($salesorder->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                                                        (strpos($salesorder->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                                                        (strpos($salesorder->invoice_no, 'SO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                                        href="{{ route('so.orderDetails', $salesorder->id) }}" 
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                                        {{ $salesorder->invoice_no }}
                                                    </a> --}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-left">
                                            <tr>
                                                <td width="32%">Dibayar Oleh</td>
                                                <td width="2%">:</td>
                                                <td><strong>{{ $paid_by }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Metode Pembayaran</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="badge {{ strpos($payment_method, 'Tunai')  !== false ? 'badge-warning' : 'badge-success' }}">
                                                        {{ $payment_method }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($payment_method === 'Tunai')
                                            <tr>
                                                <td>Diterima oleh</td>
                                                <td>:</td>
                                                <td><b>{{ $received_by->name }}</b></td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>Rekening Pengirim</td>
                                                <td>:</td>
                                                <td><b>{{ $bank->name }} - {{  $no_rek }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Rekening Penerima</td>
                                                <td>:</td>
                                                <td><b>{{ $transfer_to->bank->name }} - {{  $transfer_to->no_rek }}</b></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>Total Tagihan</td>
                                                <td>:</td>
                                                <td><span class="badge bg-danger">Rp {{ number_format($salesorder->sub_total) }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table text-end table-hover">
                                        <thead >
                                            <tr>
                                                <th colspan="3">Detail Sales Order</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-left">
                                            <tr>
                                                <td>No. Sales Order</td>
                                                <td>:</td>
                                                <td>
                                                    <a class="badge 
                                                        {{ strpos($salesorder->invoice_no, 'SOR') !== false ? 'badge-primary' : 
                                                            (strpos($salesorder->invoice_no, 'SOH') !== false ? 'badge-danger' : 
                                                            (strpos($salesorder->invoice_no, 'SO') !== false ? 'badge-warning' : 'badge-secondary')) }}" 
                                                            href="{{ route('so.orderDetails', $salesorder->id) }}" 
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                                        {{ $salesorder->invoice_no }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Pemesanan</td>
                                                <td>:</td>
                                                <td>{{ $salesorder->order_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Lembaga</td>
                                                <td>:</td>
                                                <td>{{ $salesorder->customer->NamaLembaga }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Customer</td>
                                                <td>:</td>
                                                <td>{{ $salesorder->customer->NamaCustomer }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-5">
                                    <table class="table text-end table-hover">
                                        <thead>
                                            <tr>
                                                <th>Keterangan</th>
                                                <th>Persentase</th>
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
                                <button type="button" class="btn bg-success me-3 confirm-button"><b>{{ $collection['label'] }}</b></button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
