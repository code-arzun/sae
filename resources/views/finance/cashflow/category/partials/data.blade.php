<tr>
    <td>{{ $cashflowcategory->category }}</td>
    <td>{{ $cashflowcategory->detail }}</td>
    <td>
        <div class="d-flex justify-content-between">
                <a href="#" class="badge bg-warning me-2" data-bs-toggle="modal" data-bs-target="#editKategoriTransaksi{{ $cashflowcategory->id }}"><i class="ti ti-edit"></i></a>
                @include('finance.cashflow.category.edit')

                <form action="{{ route('cashflowcategory.destroy', $cashflowcategory->id) }}" method="POST" style="margin-bottom: 5px">
                    @method('delete')
                    @csrf
                    <button type="submit" class="badge bg-danger me-2" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ti ti-trash"></i></button>
                </form>
        </div>
    </td>
</tr>