@extends('layouts.app')

@section('title', 'Add Data')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</a></div>
                    <div class="breadcrumb-item">Analisa Fuel</a></div>
                    <div class="breadcrumb-item">Add Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('analisa_fuel.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Add Data</h4>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="form-group">
                                <label>Status</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="normal" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Normal</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="caution" class="selectgroup-input">
                                        <span class="selectgroup-button">Caution</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="critical" class="selectgroup-input">
                                        <span class="selectgroup-button">Critical</span>
                                    </label>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Input Fields -->
                            <div class="form-group">
                                <label>Lab Number</label>
                                <input type="text" class="form-control @error('lab_number') is-invalid @enderror" name="lab_number">
                                @error('lab_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name">
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control @error('branch') is-invalid @enderror" name="branch">
                                @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Sample Date</label>
                                <input type="date" class="form-control @error('sample_date') is-invalid @enderror" name="sample_date">
                                @error('sample_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Report Date</label>
                                <input type="date" class="form-control @error('report_date') is-invalid @enderror" name="report_date">
                                @error('report_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Unit -->
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control" name="unit" id="unit">
                                    <option value="">Pilih Unit</option>
                                    <option value="excavator">Excavator</option>
                                    <option value="dumptruck">Heavy Dumptruck</option>
                                    <option value="grader">Motor Grader</option>
                                    <option value="doozer">Doozer</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type Unit -->
                            <div class="form-group">
                                <label>Type Unit</label>
                                <select class="form-control" name="type_unit" id="type_unit">
                                    <option value="">Pilih Type Unit</option>
                                </select>
                                @error('type_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code Unit -->
                            <div class="form-group">
                                <label>Code Unit</label>
                                <select class="form-control" name="code_unit" id="code_unit">
                                    <option value="">Pilih Code Unit</option>
                                </select>
                                @error('code_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Serial Number</label>
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#unit').change(function() {
        var unit = $(this).val();
        $('#type_unit').empty().append('<option value="">Pilih Type Unit</option>');
        $('#code_unit').empty().append('<option value="">Pilih Code Unit</option>');
        $('input[name="serial_number"]').val(''); // Kosongkan serial number saat unit diubah

        if (unit === 'excavator') {
            $('#type_unit').append('<option value="PC850-8">PC850-8</option>');
            $('#type_unit').append('<option value="PC1250-8">PC1250-8</option>');
            $('#type_unit').append('<option value="PC2000-8">PC2000-8</option>');
        } else if (unit === 'dumptruck') {
            $('#type_unit').append('<option value="GD825-2">GD825-2</option>');
        } else if (unit === 'grader') {
            $('#type_unit').append('<option value="GD755-5">GD755-5</option>');
            $('#type_unit').append('<option value="GD825-2">GD825-2</option>');
        } else if (unit === 'doozer') {
            $('#type_unit').append('<option value="D155-6R">D155-6R</option>');
        }
    });

    $('#type_unit').change(function() {
        var typeUnit = $(this).val();
        $('#code_unit').empty().append('<option value="">Pilih Code Unit</option>');

        // Kode unit untuk Excavator
        if (typeUnit === 'PC850-8') {
            $('#code_unit').append('<option value="E8507">E8507</option>');
            $('#code_unit').append('<option value="E8502">E8502</option>');
            $('#code_unit').append('<option value="E8505">E8505</option>');
            $('#code_unit').append('<option value="E8509">E8509</option>');
            $('#code_unit').append('<option value="E8510">E8510</option>');
            $('#code_unit').append('<option value="E8511">E8511</option>');
            $('#code_unit').append('<option value="E8508">E8508</option>');
        } else if (typeUnit === 'PC1250-8') {
            $('#code_unit').append('<option value="E1210">E1210</option>');
            $('#code_unit').append('<option value="E1211">E1211</option>');
        } else if (typeUnit === 'PC2000-8') {
            $('#code_unit').append('<option value="E2022">E2022</option>');
            $('#code_unit').append('<option value="E2024">E2024</option>');
            $('#code_unit').append('<option value="E2027">E2027</option>');
            $('#code_unit').append('<option value="E2030">E2030</option>');
            $('#code_unit').append('<option value="E2007">E2007</option>');
            $('#code_unit').append('<option value="E2010">E2010</option>');
            $('#code_unit').append('<option value="E2011">E2011</option>');
            $('#code_unit').append('<option value="E2032">E2032</option>');
            $('#code_unit').append('<option value="E2031">E2031</option>');
        }
        // Kode unit untuk Heavy Dumptruck
        else if (typeUnit === 'GD825-2') {
            $('#code_unit').append('<option value="GD804">GD804</option>');
            $('#code_unit').append('<option value="GD805">GD805</option>');
            $('#code_unit').append('<option value="GD806">GD806</option>');
            $('#code_unit').append('<option value="GD808">GD808</option>');
            $('#code_unit').append('<option value="GD811">GD811</option>');
            $('#code_unit').append('<option value="GD831">GD831</option>');
        }
        // Kode unit untuk Motor Grader
        else if (typeUnit === 'GD755-5') {
            $('#code_unit').append('<option value="GD7501">GD7501</option>');
            $('#code_unit').append('<option value="G57502AMM">G57502AMM</option>');
        } else if (typeUnit === 'GD825-2') {
            $('#code_unit').append('<option value="GD804">GD804</option>');
            $('#code_unit').append('<option value="GD805">GD805</option>');
            $('#code_unit').append('<option value="GD806">GD806</option>');
            $('#code_unit').append('<option value="GD808">GD808</option>');
            $('#code_unit').append('<option value="GD811">GD811</option>');
            $('#code_unit').append('<option value="GD831">GD831</option>');
        }
        // Kode unit untuk Doozer
        else if (typeUnit === 'D155-6R') {
            $('#code_unit').append('<option value="D1505">D1505</option>');
            $('#code_unit').append('<option value="D1507">D1507</option>');
            $('#code_unit').append('<option value="D1509">D1509</option>');
            $('#code_unit').append('<option value="D1513">D1513</option>');
            $('#code_unit').append('<option value="D1514">D1514</option>');
            $('#code_unit').append('<option value="D1517">D1517</option>');
            $('#code_unit').append('<option value="D1533">D1533</option>');
            $('#code_unit').append('<option value="D5104AMM">D5104AMM</option>');
            $('#code_unit').append('<option value="H57113AMM">H57113AMM</option>');
            $('#code_unit').append('<option value="H57114AMM">H57114AMM</option>');
        }
    });

    $('#code_unit').change(function() {
        var codeUnit = $(this).val();
        var serialNumbers = {
            'E2022': 'J10048', 'E2024': 'J10049', 'E2027': '20786', 'E2030': '20802', 
            'E2007': '20687', 'E2010': '20695', 'E2011': '20700', 'E2032': '20393', 
            'E2031': '20810', 'E1210': 'J10121', 'E1211': 'J10122', 'E8507': '70317', 
            'E8502': '70116', 'E8505': '70142', 'E8509': '70330', 'E8510': '70333', 
            'E8511': '70421', 'E8508': '70318', 'HD78147': '32406', 'HD78148': '32407', 
            'HD78149': '32408', 'HD78150': '32553', 'HD78172': '32183', 'HD78173': '32184', 
            'HD78174': '32185', 'HD78175': '32186', 'HD78176': '32187', 'HD78177': '32208', 
            'HD78178': '32209', 'HD78179': '32210', 'HD78180': '32212', 'HD78181': '32216', 
            'HD78182': '32218', 'HD78183': '32221', 'HD78184': '32222', 'HD78185': '32283', 
            'HD78186': '32285', 'HD78187': '32289', 'HD78188': '32290', 'HD78189': '32292', 
            'HD78190': '32349', 'HD78191': '32350', 'HD78203': '32576', 'HD78204': '32619', 
            'HD78205': '32700', 'HD78216': '32656', 'HD78217': '32658', 'HD78227': '32577', 
            'HD78228': '32611', 'HD78229': '32612', 'HD78230': '32617', 'HD78245': 'J30414', 
            'HD78246': 'J30415', 'HD78247': 'J30416', 'HD78248': 'J30417', 'HD78249': 'J30418', 
            'HD78250': 'J30419', 'HD78251': 'J30420', 'HD78252': 'J30421', 'HD78344': 'J30619', 
            'HD78345': 'J30620', 'HD78346': 'J30621', 'HD78253': 'J30422', 'HD7801': 'J20387', 
            'HD7802': 'J20398', 'HD7803': 'J20400', 'HD7804': 'J20402', 'HD7805': 'J20404', 
            'HD7806': 'J20406', 'HD7807': 'J20407', 'HD7808': 'J20408', 'HD7809': 'J20409', 
            'HD7810': 'J20410', 'HD7811': 'J20411', 'HD7812': '30211', 'GD7501': '10344', 
            'G57502AMM': '10365', 'GD804': '13036', 'GD805': '13098', 'GD806': '13112', 
            'GD808': '13116', 'GD811': '13147', 'GD831': '13419', 'D1505': '87371', 
            'D1507': '87390', 'D1509': '87397', 'D1513': '87422', 'D1514': '87418', 
            'D1517': '87556', 'D1533': '88091', 'D5104AMM': '87786', 'H57113AMM': '32556', 
            'H57114AMM': '32557'
        };

        if (serialNumbers[codeUnit]) {
            $('input[name="serial_number"]').val(serialNumbers[codeUnit]);
        } else {
            $('input[name="serial_number"]').val(''); // Kosongkan jika tidak ditemukan
        }
    });
});



</script>
@endpush
