@extends('layout.main')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('retur.index') }}">Retur</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('input.retur') }}">Input</a></li>
@endsection

@section('container')

<div class="mb-3">
    <h4>Sales Order</h4>
    <div class="card">
        <div class="card-body row">
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Tanggal SO</label>
                <h5>{{Carbon\Carbon::parse($retur->delivery->salesorder->order_date)->translatedformat('l, d F Y') }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nomor SO</label>
                <div>
                    <a href="{{ route('so.orderDetails', $retur->delivery->salesorder->id) }}" class="badge {{ strpos($retur->delivery->salesorder->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($retur->delivery->salesorder->invoice_no, '-H') !== false ? 'bg-danger' : 
                            (strpos($retur->delivery->salesorder->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($retur->delivery->salesorder->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                        {{ $retur->delivery->salesorder->invoice_no }}
                    </a>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nama Lembaga</label>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                    href="{{ route('customers.show', $retur->delivery->salesorder->customer->id) }}">
                    <h5>{{ $retur->delivery->salesorder->customer->NamaLembaga }}</h5>
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nama Customer</label>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Customer"
                    href="{{ route('customers.show', $retur->delivery->salesorder->customer->id) }}">
                    <h5>{{ $retur->delivery->salesorder->customer->NamaCustomer }}</h5>
                </a>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Jabatan</label>
                <div>
                    <span class="badge bg-secondary">{{ $retur->delivery->salesorder->customer->Jabatan }}</span>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Sales</label>
                <h5>{{ $retur->delivery->salesorder->customer->employee->name }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <h4>Detail Delivery Order</h4>
    <div class="card">
        <div class="card-body row">
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Tanggal DO</label>
                <h5>{{Carbon\Carbon::parse($retur->delivery->delivery_date)->translatedformat('l, d F Y') }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Nomor DO</label>
                <div>
                    <a href="{{ route('do.deliveryDetails', $retur->delivery->id) }}" class="badge {{ strpos($retur->delivery->invoice_no, '-R') !== false ? 'bg-primary' : (strpos($retur->delivery->invoice_no, '-H') !== false ? 'bg-danger' : 
                            (strpos($retur->delivery->invoice_no, '-RS') !== false ? 'bg-success' : (strpos($retur->delivery->invoice_no, '-HS') !== false ? 'bg-warning' : 'bg-secondary'))) }}">
                        {{ $retur->delivery->invoice_no }}
                    </a>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Pengiriman</label>
                <div class="d-flex">
                    ke-<h5>{{ $retur->delivery->delivery_order }}</h5>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Status Pengiriman</label>
                <div>
                    <span class="badge {{ strpos($retur->delivery->delivery_status, 'Siap dikirim') !== false ? 'bg-danger' : (strpos($retur->delivery->delivery_status, 'Dalam Pengiriman') !== false ? 'bg-warning' : 'bg-success') }}">
                        {{ $retur->delivery->delivery_status }}
                    </span>
                </div>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Diinput pada</label>
                <h5>{{ $retur->delivery->created_at ? Carbon\Carbon::parse($retur->delivery->created_at)->translatedFormat('H:i - d M Y') : '' }}</h5>
            </div>
            <div class="col-md-2 d-flex flex-column mb-3">
                <label class="mb-2">Diperbarui pada</label>
                <h5>{{ $retur->delivery->updated_at ? Carbon\Carbon::parse($retur->delivery->updated_at)->translatedFormat('H:i - d M Y') : '' }}</h5>
            </div>

            @php
                $steps = [
                    ['label' => 'Terpacking', 'icon' => 'ti ti-box f-30', 'key' => 'packed_at'],
                    ['label' => 'Dikirim', 'icon' => 'fas fa-truck f-20', 'key' => 'sent_at'],
                    ['label' => 'Terkirim', 'icon' => 'ti ti-check f-30', 'key' => 'delivered_at'],
                ];

                // Status yang aktif
                $statuses = [
                    'Siap dikirim' => 1,
                    'Dalam Pengiriman' => 2,
                    'Terkirim' => 3,
                ];

                $currentStep = $statuses[$retur->delivery->delivery_status] ?? 0;
                $progressWidth = ($currentStep - 1) * 50;
            @endphp

            <div class="p-3 p-sm-5">
                <div class="position-relative">
                    <div class="progress" style="height: 3px">
                        @if ($currentStep > 1)
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressWidth }}%" aria-valuenow="{{ $progressWidth }}" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                    </div>
                    @foreach ($steps as $index => $step)
                        @php
                            $stepIndex = $index + 1;
                            $iconColor = $stepIndex <= $currentStep ? 'bg-primary' : 'bg-secondary';
                            $positionClass = match ($stepIndex) {
                                1 => 'start-0',
                                2 => 'start-50',
                                3 => 'start-100',
                            };
                        @endphp
                        <div class="avtar avtar-s rounded-circle text-white {{ $iconColor }} position-absolute top-0 {{ $positionClass }} translate-middle" style="width: 3rem; height: 3rem">
                            <i class="{{ $step['icon'] }}"></i>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-between">
                @foreach ($steps as $step)
                    <div class="mb-3">
                        <label class="mb-1 d-block">{{ $step['label'] }}</label>
                        <h5>
                            @if (!empty($retur->delivery->{$step['key']}))
                                {{ \Carbon\Carbon::parse($retur->delivery->{$step['key']})->translatedFormat('H:i - l, d F Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </h5>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<div class="dt-responsive">
    <table class="table nowrap mb-3">
        <thead>
            <tr>
                <th width="3px">No.</th>
                <th>Produk</th>
                <th width="250px">Kategori</th>
                <th width="150px">Jumlah</th>
                <th width="150px">Harga Satuan</th>
                <th width="200px">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($returDetails as $item)
            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td><b>{{ $item->product->product_name }}</b></td>
                <td>{{ $item->product->category->name }}</td>
                <td class="text-center"><b class="me-1">{{ number_format($item->quantity) }}</b>{{ $item->product->category->productunit->name }}</td>
                <td class="text-end">Rp {{ number_format($item->unitcost) }}</td>
                <td class="text-end">Rp {{ number_format($item->total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="offset-6">
        <table class="table text-end">
                <tr>
                    <th class="text-start">Jumlah Item</th>
                    <td class="text-start"><span class="badge bg-secondary">{{ number_format($returDetails->count('product')) }}</span></td>
                    <th class="text-start">Total Produk</th>
                    <td class="text-start"><span class="badge bg-secondary me-2">{{ number_format($retur->delivery->total_products) }}</span>{{ $item->product->category->productunit->name }}</td>
                    <th>Subtotal</th>
                    <td><span class="badge bg-success">Rp {{ number_format($retur->sub_total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@include('components.preview-img-form')
@endsection
