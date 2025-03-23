<th width="5px">No.</th>
<th>Tgl. Pesan</th>
<th width="160px">No. SO</th>
<th>Customer</th>
@if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Admin Gudang']))
<th>Sales</th>
@endif
<th>Subtotal</th>
@if (auth()->user()->hasAnyRole(['Super Admin', 'Manajer Marketing', 'Admin', 'Sales']))
<th colspan="2">Diskon</th>
<th>Grand Total</th>
{{-- <th class="bg-primary text-white"><i class="fas fa-cog me-3"></i>Status SO</th> --}}
@endif