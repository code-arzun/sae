<div class="dt-responsive table-responsive mb-3">
    <table class="table ">
        <thead>
            <tr>
                <th width="7%">Tgl</th>
                <th width="5%">Kode</th>
                <th>Divisi</th>
                <!-- <th>Jenis Transaksi</th> -->
                <th>Kategori</th>
                <th>Keterangan</th>
                <th width="10%" class="bg-success">
                    <span class="me-2">Pemasukan</span>
                    <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Pemasukan yang tercatat">{{ number_format($cashflows->where('cashflowcategory.type', 'Pemasukan')->count('nominal')) }}</span>
                </th>
                <th width="10%" class="bg-danger">
                    <span class="me-2">Pengeluaran</span>
                    <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Jumlah Pengeluaran yang tercatat">{{ number_format($cashflows->where('cashflowcategory.type', 'Pengeluaran')->count('nominal')) }}</span>
                </th>
                <th width="6%">Diinput</th>
                <th width="10%">Diinput pada</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cashflows as $cashflow)
            <tr>
                <td>
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($cashflow->date)->translatedformat('l, d F Y') }}">
                        {{ Carbon\Carbon::parse($cashflow->date)->translatedformat('d M Y') }}
                    </span>
                </td>
                <td>
                    @if ($cashflow->cashflowcategory->type === 'Pemasukan')
                        <span class="badge bg-success">{{ $cashflow->cashflow_code }}</span>
                    @else
                        <span class="badge bg-danger">{{ $cashflow->cashflow_code }}</span>
                    @endif
                </td>
                <th>{{ $cashflow->department->name }}</th>
                <!-- 
                    <td>
                        <span class="badge {{ $cashflow->cashflowcategory->type === 'Pemasukan' ? 'bg-success' : 'bg-danger' }}">
                            {{ $cashflow->cashflowcategory->type }}
                        </span>
                    </td>
                -->
                <td>{{ $cashflow->cashflowcategory->category }} {{ $cashflow->cashflowcategory->detail }}</td>
                <td>{{ $cashflow->notes }}</td>
                @if ($cashflow->cashflowcategory->type === 'Pemasukan')
                    <td class="accounting subtotal">{{ number_format($cashflow->nominal) }}</td>
                    <td class="text-end">-</td>
                    @else
                    <td class="text-end">-</td>
                    <td class="accounting discountRp">{{ number_format($cashflow->nominal) }}</td>
                @endif
                <th>{{ explode(' ', $cashflow->createdBy->employee->name)[0] }}</th>
                <td class="text-center">{{ Carbon\Carbon::parse($cashflow->created_at)->translatedformat('H:i - d M Y') }}</td>
            </tr>

            @empty
                @include('layout.partials.alert-danger')
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end">Total</th>
                <th class="bg-success text-end text-white">Rp {{ number_format($cashflows->where('cashflowcategory.type', 'Pemasukan')->sum('nominal')) }}</th>
                <th class="bg-danger text-end text-white">Rp {{ number_format($cashflows->where('cashflowcategory.type', 'Pengeluaran')->sum('nominal')) }}</th>
            </tr>
            <tr>
                <th colspan="5" class="text-end">Jumlah Transaksi</th>
                <th class="bg-success text-center text-white">{{ number_format($cashflows->where('cashflowcategory.type', 'Pemasukan')->count('nominal')) }}</th>
                <th class="bg-danger text-center text-white">{{ number_format($cashflows->where('cashflowcategory.type', 'Pengeluaran')->count('nominal')) }}</th>
            </tr>
            
        </tfoot>
    </table>
</div>