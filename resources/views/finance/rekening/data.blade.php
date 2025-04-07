<div class="dt-responsive table-responsive mb-3">
    <table class="table mb-0">
        <thead>
            <tr>
                <th width="10%">Bank</th>
                <th width="20%">No. Rek</th>
                <th width="10%">Nama</th>
                <th width="5%">#</th>
                <th>Riwayat Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekenings as $rekening)
            <tr>
                <th>{{ $rekening->bank->name }}</th>
                <td>{{ $rekening->no_rek }}</td>
                <th>{{ $rekening->nama }}</th>
                <td>
                    <div class="d-flex justify-content-center">
                        <!-- Edit -->
                        <a href="#" class="badge bg-warning me-1" data-bs-toggle="modal" data-bs-target="#editRekening{{ $rekening->id }}"><i class="ti ti-edit"></i></a>
                        @include('finance.rekening.edit')
                        <!-- Delete -->
                        <form action="{{ route('rekening.destroy', $rekening->id) }}" method="POST" style="margin-bottom: 5px">
                            @method('delete')
                            @csrf
                            <button type="submit" class="badge bg-danger me-2" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>

            @empty
                @include('layout.partials.session')
            @endforelse
        </tbody>
    </table>
</div>