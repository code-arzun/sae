<div id="showTransaksi{{ $cashflow->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showTransaksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="showTransaksiLabel">{{ $title }}</h3>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="modal-body bg-white">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <!-- Tanggal -->
                            <div class="form-group col-md-4">
                                <label for="date" class="text-muted mb-1">Tanggal</label>
                                <h5>{{ Carbon\Carbon::parse($cashflow->date)->translatedformat('l, d F Y') }}</h5>
                            </div>
                            <!-- Divisi -->
                            <div class="form-group col-md-4">
                                <label for="department_id" class="text-muted mb-1">Divisi</label>
                                <h5>{{ $cashflow->department->name }}</h5>
                            </div>
                            <!-- Kode -->
                            <div class="form-group col-md-4">
                                <label for="department_id" class="text-muted mb-1">Kode</label>
                                @if ($cashflow->cashflowcategory->type === 'Pemasukan')
                                <h5 class="text-success">{{ $cashflow->cashflow_code }}</h5>
                                @else
                                <h5 class="text-danger">{{ $cashflow->cashflow_code }}</h5>
                                @endif
                            </div>
                            <!-- Jenis Transaksi -->
                            <div class="form-group col-md-4 d-flex flex-column">
                                <label for="cashflowcategory_id" class="text-muted mb-1">Jenis Transaksi</label>
                                <div>
                                    @if ($cashflow->cashflowcategory->type === 'Pemasukan')
                                    <span class="badge bg-success">{{ $cashflow->cashflowcategory->type }}</span>
                                    @else
                                    <span class="badge bg-danger">{{ $cashflow->cashflowcategory->type }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Kategori -->
                            <div class="form-group col-md-4">
                                <label for="cashflowcategory_id" class="text-muted mb-1">Kategori</label>
                                <h5>{{ $cashflow->cashflowcategory->category }} {{ $cashflow->cashflowcategory->detail }}</h5>
                            </div>
                            <!-- Nominal -->
                            <div class="form-group col-md-4">
                                <label for="nominal" class="text-muted mb-1">Nominal</label>
                                <h5>Rp {{ number_format($cashflow->nominal) }}</h5>
                            </div>
                            <!-- Detail -->
                            <div class="form-group col-md-12">
                                <label for="notes" class="text-muted mb-1">Detail</label>
                                <h5>{{ $cashflow->cashflowcategory->category }} {{ $cashflow->cashflowcategory->detail }} {{ $cashflow->notes }}</h5>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Bukti Transaksi -->
                    <div class="col-md-2 d-flex flex-column">
                        <label for="receipt" class="text-muted mb-1">Bukti Transaksi</label>
                        <div class="input-group-append">
                            <a href="{{ asset($cashflow->receipt) }}" target="_blank">
                                <img src="{{ $cashflow->receipt ? asset($cashflow->receipt) : asset(Storage::url('cashflow/default.jpg')) }}" alt="{{ $cashflow->cashflow_code }} | {{ $cashflow->cashflowcategory->category }} {{ $cashflow->cashflowcategory->detail }} {{ $cashflow->notes }}" class="img-fluid" width="100%">
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Created by -->
                        <div class="form-group col-md-2">
                            <label for="createdBy" class="text-muted mb-1">Diinput oleh</label>
                            <h5>{{ $cashflow->createdBy->employee->name }}</h5>
                        </div>
                        <!-- Created at -->
                        <div class="form-group col-md-4">
                            <label for="created_at" class="text-muted mb-1">Diinput pada</label>
                            <h5>{{ Carbon\Carbon::parse($cashflow->created_at)->translatedformat('h:i:s - l, d F Y') }}</h5>
                        </div>
                        @if ($cashflow->created_at == $cashflow->updated_at)
                        @else
                        <!-- Updated by -->
                        <div class="form-group col-md-2">
                            <label for="updatedBy" class="text-muted mb-1">Diperbarui oleh</label>
                            <h5>{{ $cashflow->updatedBy?->employee->name }}</h5>
                        </div>
                        <!-- Updated at -->
                        <div class="form-group col-md-4">
                            <label for="updated_at" class="text-muted mb-1">Diperbarui pada</label>
                            <h5>{{ Carbon\Carbon::parse($cashflow->updated_at)->translatedformat('h:i:s - l, d F Y') }}</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
