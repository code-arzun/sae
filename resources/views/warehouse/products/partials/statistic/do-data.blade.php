<!-- DO terpacking -->
<td class="text-center">
    @if ($product->rekap_DOterpacking > 0)
        <h5 class="text-danger">{{ $product->rekap_DOterpacking }}</h5>
    @else
        <h5 class="text-success">{{ $product->rekap_DOterpacking }}</h5>
    @endif
</td>
<!-- DO dalam pengiriman -->
<td class="text-center">
    @if ($product->rekap_DOpengiriman > 0)
        <h5 class="text-danger">{{ $product->rekap_DOpengiriman }}</h5>
    @else
        <h5 class="text-success">{{ $product->rekap_DOpengiriman }}</h5>
    @endif
</td>
<!-- DO terkirim -->
<td class="text-center">
    @if ($product->rekap_DOterkirim > 0)
        <h5 class="text-danger">{{ $product->rekap_DOterkirim }}</h5>
    @else
        <h5 class="text-success">{{ $product->rekap_DOterkirim }}</h5>
    @endif
</td>