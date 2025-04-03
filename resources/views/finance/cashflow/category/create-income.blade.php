<div id="createIncomeCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createIncomeCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h3 class="modal-title text-white" id="createIncomeCategoryLabel">Tambah Kategori Pemasukan Baru</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-gray-100">
                <form action="{{ route('cashflowcategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Jenis Transaksi -->
                        <div class="form-group col-md-6" hidden>
                            <label for="type">Jenis Transaksi</label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type">
                                <option value="Pemasukan" selected>Pemasukan</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Kategori -->
                        <div class="form-group col-md-3">
                            <label for="category">Kategori</label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category">
                                <option value="" selected disabled>-- Kategori --</option>
                                <option value="Modal">Modal</option>
                                <option value="Penjualan">Penjualan</option>
                                <option value="Pembayaran">Pembayaran</option>
                                <option value="Pembelian">Pembelian</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Detail Transaksi -->
                        <div class="form-group col-md">
                            <label for="detail">Detail</label>
                            <input type="text" class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" value="{{ old('detail') }}" placeholder="Masukkan detail transaksi">
                            @error('detail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
  </div>