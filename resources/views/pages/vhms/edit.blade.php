@extends('layouts.app')

@section('title', 'Edit VHMS Data')

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Edit VHMS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item">VHMS</div>
                    <div class="breadcrumb-item active">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit VHMS Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vhms.update', $vhms->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Dropdown Code -->
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <select name="code" id="code" class="form-control" required>
                                            <option value="">-- Select Code --</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->code_unit }}"
                                                    {{ $vhms->code == $unit->code_unit ? 'selected' : '' }}>
                                                    {{ $unit->code_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input SN (otomatis) -->
                                    <div class="form-group">
                                        <label for="sn">Serial Number</label>
                                        <input type="text" name="sn" id="sn" class="form-control" value="{{ $vhms->sn }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="hm">HM</label>
                                        <input type="number" name="hm" class="form-control" value="{{ old('hm', $vhms->hm) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="blowby_max">Blowby Max</label>
                                        <input type="number" step="0.01" name="blowby_max" class="form-control" value="{{ old('blowby_max', $vhms->blowby_max) }}" required>
                                    </div>

                                    <!-- Tambahkan form input lainnya seperti create -->
                                    @foreach(['boost_press_max', 'exh_temp_lf_max', 'exh_temp_lr_max', 'exh_temp_rf_max', 'exh_temp_rr_max', 'eng_oil_press_hmin', 'eng_oil_press_lmin', 'coolant_temp_max', 'eng_oil_temp_max', 'tm_oil_temp_max'] as $field)
                                    <div class="form-group">
                                        <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                        <input type="number" step="0.01" name="{{ $field }}" class="form-control" value="{{ old($field, $vhms->$field) }}" required>
                                    </div>
                                    @endforeach

                                    <button type="submit" class="btn btn-success mt-3">Update</button>
                                    <a href="{{ route('vhms.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('code').addEventListener('change', function() {
        let code_unit = this.value;
        let snField = document.getElementById('sn');

        fetch(`{{ route('vhms.getSerialNumber') }}?code_unit=${code_unit}`)
            .then(response => response.json())
            .then(data => {
                snField.value = data.serial_number || '';
            })
            .catch(error => console.error('Error:', error));
    });

    // Trigger on load for selected value
    window.onload = function() {
        let selectedCode = document.getElementById('code').value;
        if (selectedCode) {
            fetch(`{{ route('vhms.getSerialNumber') }}?code_unit=${selectedCode}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('sn').value = data.serial_number || '';
                });
        }
    };
</script>
@endpush
