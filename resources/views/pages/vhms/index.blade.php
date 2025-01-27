@extends('layouts.app')

@section('title', 'VHMS')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>VHMS</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item active">VHMS</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('vhms.create') }}" class="btn btn-primary mr-2">Add New</a>
                                </div>
                                {{-- <form action="{{ route('vhms.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items center">
                                    @csrf
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="csv_file" class="custom-file-input" id="csvFile" accept=".xlsx, .csv, .xls">
                                            <label for="csvFile" class="custom-file-label">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success">Upload CSV</button>
                                        </div>
                                    </div>
                                </form> --}}
                                <form action="{{ route('vhms.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                    @csrf
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="uploadCsv" accept=".xlsx, .csv, .xls">
                                            <label class="custom-file-label" for="uploadCsv">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success">Upload Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('vhms.index') }}" method="GET" class="form-inline mb-4">
                                    <label for="unit" class="mr-2">Filter by Unit:</label>
                                    <select name="unit" id="unit" class="form-control mr-2">
                                        <option value="">-- Select Unit --</option>
                                        @foreach($unitCodes as $unit)
                                            <option value="{{ $unit }}" {{ $selectedUnit == $unit ? 'selected' : '' }}>
                                                {{ $unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped text-center align-middle custom-table">
                                        <thead class="custom-header">
                                            <tr>
                                                <th rowspan="2">No.</th>
                                                <th rowspan="2">Code
                                                    <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#filterUnitCodeModal">
                                                        <i class="fas fa-filter"></i>
                                                    </button>
                                                </th>
                                                <th rowspan="2">SN</th>
                                                <th rowspan="2">HM</th>
                                                <th rowspan="2">Blowby Max</th>
                                                <th rowspan="2">Boost Press. Max</th>
                                                <th colspan="4">Exh Temp</th>
                                                <th colspan="2">Eng Oil</th>
                                                <th rowspan="2">Coolant Temp Max</th>
                                                <th rowspan="2">Eng Oil Temp Max</th>
                                                <th rowspan="2">TM Oil Temp Max</th>
                                                <th rowspan="2">Actions</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="1">LF Max</th>
                                                <th rowspan="1">LR Max</th>
                                                <th rowspan="1">RF Max</th>
                                                <th rowspan="1">RR Max</th>
                                                <th rowspan="1">HMin</th>
                                                <th rowspan="1">LMin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($vhmsData as $index => $vhms)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $vhms->code }}</td>
                                                <td>{{ $vhms->sn }}</td>
                                                <td>{{ $vhms->hm }}</td>
                                                <td style="background-color: {{ $vhms->blowby_max < 4 ? '#FFFFE0' : ($vhms->blowby_max > 5.8 ? '#FFC0C0' : '#CCFFCC') }}">
                                                    {{ $vhms->blowby_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->boost_press_max < 150 ? '#FFFFE0' : ($vhms->boost_press_max > 166 ? '#FFC0C0' : '#CCFFCC') }}">
                                                    {{ $vhms->boost_press_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->exh_temp_lf_max > 750 ? '#FFC0C0' : ($vhms->exh_temp_lf_max < 650 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->exh_temp_lf_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->exh_temp_lr_max > 750 ? '#FFC0C0' : ($vhms->exh_temp_lr_max < 650 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->exh_temp_lr_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->exh_temp_rf_max > 750 ? '#FFC0C0' : ($vhms->exh_temp_rf_max < 650 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->exh_temp_rf_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->exh_temp_rr_max > 750 ? '#FFC0C0' : ($vhms->exh_temp_rr_max < 650 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->exh_temp_rr_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->eng_oil_press_hmin < 2 ? '#FFFFE0' : ($vhms->eng_oil_press_hmin > 3 ? '#FFC0C0' : '#CCFFCC') }}">
                                                    {{ $vhms->eng_oil_press_hmin }}
                                                </td>
                                                <td style="background-color: {{ $vhms->eng_oil_press_lmin < 0.8 ? '#FFFFE0' : ($vhms->eng_oil_press_lmin > 1 ? '#FFC0C0' : '#CCFFCC') }}">
                                                    {{ $vhms->eng_oil_press_lmin }}
                                                </td>
                                                <td style="background-color: {{ $vhms->coolant_temp_max > 95 ? '#FFC0C0' : ($vhms->coolant_temp_max < 85 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->coolant_temp_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->eng_oil_temp_max > 105 ? '#FFC0C0' : ($vhms->eng_oil_temp_max < 95 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->eng_oil_temp_max }}
                                                </td>
                                                <td style="background-color: {{ $vhms->tm_oil_temp_max > 100 ? '#FFC0C0' : ($vhms->tm_oil_temp_max < 90 ? '#FFFFE0' : '#CCFFCC') }}">
                                                    {{ $vhms->tm_oil_temp_max }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('vhms.edit', $vhms->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('vhms.destroy', $vhms->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="16" class="text-center">No Data Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $vhmsPage->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || "Choose file";
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>


@include('modals.filter_unit_code')

@endsection

@push('scripts')
<script>
    handleDelete('.btn-delete'); // Memanggil fungsi global untuk tombol dengan class .btn-delete
</script>
@endpush
