<tr>
    <td>{{ Carbon\Carbon::parse($cashflow->date)->translatedformat('l, d F Y') }}</td>
    <td>{{ $cashflow->cashflow_code }}</td>
    <th>{{ $cashflow->department->name }}</th>
    <td>{{ $cashflow->cashflowcategory->category }}</td>
    <td>{{ $cashflow->cashflowcategory->detail }}</td>
    <td>{{ $cashflow->notes }}</td>
    @if ($cashflow->cashflowcategory->type === 'Pemasukan')
        <td class="accounting subtotal">{{ number_format($cashflow->nominal) }}</td>
        @else
        <td class="accounting discountRp">{{ number_format($cashflow->nominal) }}</td>
    @endif
    <td>{{ $cashflow->user->employee->name }}</td>
    <td>{{ Carbon\Carbon::parse($cashflow->created_at)->translatedformat('H:i - d M Y') }}</td>
    <td>
        <form action="{{ route('cashflow.destroy', $cashflow->id) }}" method="POST" style="margin-bottom: 5px">
            @method('delete')
            @csrf
            <div class="d-flex align-items-center list-action">
                <a class="badge bg-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                    href="{{ route('cashflow.show', $cashflow->id) }}"><i class="ti ti-eye"></i>
                </a>
                <a class="badge bg-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                    href="{{ route('cashflow.edit', $cashflow->id) }}"><i class="ti ti-pencil"></i>
                </a>
                    <button type="submit" class="badge bg-warning" onclick="return confirm('Are you sure you want to delete this record?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ri-delete-bin-line me-0"></i></button>
            </div>
        </form>
    </td>
</tr>

