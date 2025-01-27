@extends('layouts.app')

@section('title', 'Add VHMS Data')

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Add VHMS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item">VHMS</div>
                    <div class="breadcrumb-item active">Add</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>New VHMS Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vhms.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Dropdown untuk Code -->
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <select name="code" id="code" class="form-control" required>
                                            <option value="">-- Select Code --</option>
                                            @foreach($unitCodes as $unit)
                                                <option value="{{ $unit->code_unit }}">{{ $unit->code_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input SN (otomatis) -->
                                    <div class="form-group">
                                        <label for="sn">Serial Number</label>
                                        <input type="text" name="sn" id="sn" class="form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="hm">HM</label>
                                        <input type="number" name="hm" class="form-control" value="{{ old('hm') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="blowby_max">Blowby Max</label>
                                        <input type="number" step="0.01" name="blowby_max" class="form-control" value="{{ old('blowby_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="boost_press_max">Boost Press Max</label>
                                        <input type="number" step="0.01" name="boost_press_max" class="form-control" value="{{ old('boost_press_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exh_temp_lf_max">Exh Temp LF Max</label>
                                        <input type="number" step="0.01" name="exh_temp_lf_max" class="form-control" value="{{ old('exh_temp_lf_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exh_temp_lr_max">Exh Temp LR Max</label>
                                        <input type="number" step="0.01" name="exh_temp_lr_max" class="form-control" value="{{ old('exh_temp_lr_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exh_temp_rf_max">Exh Temp RF Max</label>
                                        <input type="number" step="0.01" name="exh_temp_rf_max" class="form-control" value="{{ old('exh_temp_rf_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exh_temp_rr_max">Exh Temp RR Max</label>
                                        <input type="number" step="0.01" name="exh_temp_rr_max" class="form-control" value="{{ old('exh_temp_rr_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="eng_oil_press_hmin">Eng Oil Press HMin</label>
                                        <input type="number" step="0.01" name="eng_oil_press_hmin" class="form-control" value="{{ old('eng_oil_press_hmin') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="eng_oil_press_lmin">Eng Oil Press LMin</label>
                                        <input type="number" step="0.01" name="eng_oil_press_lmin" class="form-control" value="{{ old('eng_oil_press_lmin') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="coolant_temp_max">Coolant Temp Max</label>
                                        <input type="number" step="0.01" name="coolant_temp_max" class="form-control" value="{{ old('coolant_temp_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="eng_oil_temp_max">Eng Oil Temp Max</label>
                                        <input type="number" step="0.01" name="eng_oil_temp_max" class="form-control" value="{{ old('eng_oil_temp_max') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tm_oil_temp_max">TM Oil Temp Max</label>
                                        <input type="number" step="0.01" name="tm_oil_temp_max" class="form-control" value="{{ old('tm_oil_temp_max') }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-success mt-3">Save</button>
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
    // Event listener untuk dropdown 'code'
    document.getElementById('code').addEventListener('change', function() {
        let code_unit = this.value;
        let snField = document.getElementById('sn');

        console.log("Selected Code Unit:", code_unit); // Debug pilihan dropdown

        fetch(`{{ route('vhms.getSerialNumber') }}?code_unit=${code_unit}`)
            .then(response => response.json())
            .then(data => {
                console.log("Response Data:", data); // Debug respons dari server
                snField.value = data.serial_number || '';
            })
            .catch(error => console.error('Error:', error));
    });

</script>
@endpush
