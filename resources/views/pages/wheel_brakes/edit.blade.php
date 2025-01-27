@extends('layouts.app')

@section('title', 'Edit Wheel Brake')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Wheel Brake</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item">Wheel Brake</div>
                    <div class="breadcrumb-item active">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Wheel Brake Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('wheel-brakes.update', $wheelBrake->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Unit Code -->
                                    <div class="form-group">
                                        <label>Unit Code</label>
                                        <select name="unit_code" class="form-control">
                                            <option value="">-- Select Unit Code --</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->code_unit }}" {{ $wheelBrake->unit_code == $unit->code_unit ? 'selected' : '' }}>
                                                    {{ $unit->code_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- HM -->
                                    <div class="form-group">
                                        <label>HM</label>
                                        <input type="number" name="hm" class="form-control" value="{{ $wheelBrake->hm }}">
                                    </div>

                                    <!-- Last Date -->
                                    <div class="form-group">
                                        <label>Last Date</label>
                                        <input type="text" name="last_date" id="last_date" class="form-control"
                                        value="{{ old('last_update', $wheelBrake->last_update) }}">
                                    </div>

                                    <!-- FLH -->
                                    <div class="form-group">
                                        <label>FLH R.Gauge</label>
                                        <input type="number" step="0.01" name="flh_rgauge" class="form-control" value="{{ $wheelBrake->flh_rgauge }}">
                                    </div>
                                    <div class="form-group">
                                        <label>FLH T.Base</label>
                                        <input type="number" step="0.01" name="flh_tbase" class="form-control" value="{{ $wheelBrake->flh_tbase }}">
                                    </div>

                                    <!-- FRH -->
                                    <div class="form-group">
                                        <label>FRH R.Gauge</label>
                                        <input type="number" step="0.01" name="frh_rgauge" class="form-control" value="{{ $wheelBrake->frh_rgauge }}">
                                    </div>
                                    <div class="form-group">
                                        <label>FRH T.Base</label>
                                        <input type="number" step="0.01" name="frh_tbase" class="form-control" value="{{ $wheelBrake->frh_tbase }}">
                                    </div>

                                    <!-- RLH -->
                                    <div class="form-group">
                                        <label>RLH R.Gauge</label>
                                        <input type="number" step="0.01" name="rlh_rgauge" class="form-control" value="{{ $wheelBrake->rlh_rgauge }}">
                                    </div>
                                    <div class="form-group">
                                        <label>RLH T.Base</label>
                                        <input type="number" step="0.01" name="rlh_tbase" class="form-control" value="{{ $wheelBrake->rlh_tbase }}">
                                    </div>

                                    <!-- RRH -->
                                    <div class="form-group">
                                        <label>RRH R.Gauge</label>
                                        <input type="number" step="0.01" name="rrh_rgauge" class="form-control" value="{{ $wheelBrake->rrh_rgauge }}">
                                    </div>
                                    <div class="form-group">
                                        <label>RRH T.Base</label>
                                        <input type="number" step="0.01" name="rrh_tbase" class="form-control" value="{{ $wheelBrake->rrh_tbase }}">
                                    </div>

                                    <!-- Picture -->
                                    <div class="form-group">
                                        <label>Picture</label>
                                        <input type="file" name="picture" class="form-control-file">
                                        @if ($wheelBrake->picture)
                                            <p>Current Picture: <a href="{{ asset('storage/' . $wheelBrake->picture) }}" target="_blank">View</a></p>
                                        @endif
                                    </div>

                                    <!-- Submit -->
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#last_date", {
            dateFormat: "d-m-Y", // Format tanggal
            allowInput: true, // Memungkinkan pengguna mengetik manual
            defaultDate: document.getElementById('last_date').value // Set default date
        });
    });
    </script>

@endpush
