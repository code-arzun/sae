<div class="dt-responsive table-responsive mb-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="7%">Tgl</th>
                <th width="5%">Kode</th>
                <th>Divisi</th>
                <!-- <th>Jenis Transaksi</th> -->
                <th>Kategori</th>
                <th>Keterangan</th>
                <th width="10%" class="bg-success">Pemasukan</th>
                <th width="10%" class="bg-danger">Pengeluaran</th>
                <th width="6%">Diinput</th>
                <th width="10%">Diinput pada</th>
                <th width="6%">#</th>
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
                <th class="text-center">{{ explode(' ', $cashflow->user->employee->name)[0] }}</th>
                <td class="text-center">{{ Carbon\Carbon::parse($cashflow->created_at)->translatedformat('H:i - d M Y') }}</td>
                <td>
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- show -->
                        <a href="#" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#showTransaksi{{ $cashflow->id }}"><i class="ti ti-eye"></i></a>
                        @include('finance.cashflow.show')
                        <!-- Edit -->
                        <a href="#" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#editTransaksi{{ $cashflow->id }}"><i class="ti ti-edit"></i></a>
                        @include('finance.cashflow.edit')
                        <form action="{{ route('cashflow.destroy', $cashflow->id) }}" method="POST" style="margin-bottom: 5px">
                            @method('delete')
                            @csrf
                                    <button type="submit" class="badge bg-danger" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ti ti-trash"></i></button>
                            </div>
                        </form>
                </td>
            </tr>

            @empty
                @include('layout.partials.alert-danger')
            @endforelse
        </tbody>
    </table>
</div>