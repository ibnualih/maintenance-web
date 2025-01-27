@extends('layouts.app')

@section('title', 'Add Wheel Brake')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Wheel Brake</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item">Wheel Brake</div>
                    <div class="breadcrumb-item active">Add</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>New Wheel Brake Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('wheel-brakes.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Unit Code -->
                                    <div class="form-group">
                                        <label>Unit Code</label>
                                        <select name="unit_code" class="form-control">
                                            <option value="">-- Select Unit Code --</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->code_unit }}" {{ old('unit_code') == $unit->code_unit ? 'selected' : '' }}>
                                                    {{ $unit->code_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- HM -->
                                    <div class="form-group">
                                        <label>HM</label>
                                        <input type="number" name="hm" class="form-control" value="{{ old('hm') }}">
                                    </div>

                                    <!-- ED -->
                                    <div class="form-group">
                                        <label>ED</label>
                                        <input type="number" name="ed" class="form-control" value="{{ old('ed') }}">
                                    </div>

                                    <!-- Last Date -->
                                    <div class="form-group">
                                        <label>Last Date</label>
                                        <input type="date" name="last_date" class="form-control" value="{{ old('last_date') }}">
                                    </div>

                                    <!-- FLH -->
                                    <div class="form-group">
                                        <label>FLH R.Gauge</label>
                                        <input type="number" step="0.01" name="flh_rgauge" class="form-control" value="{{ old('flh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>FLH T.Base</label>
                                        <input type="number" step="0.01" name="flh_tbase" class="form-control" value="{{ old('flh_tbase') }}">
                                    </div>

                                    <!-- FRH -->
                                    <div class="form-group">
                                        <label>FRH R.Gauge</label>
                                        <input type="number" step="0.01" name="frh_rgauge" class="form-control" value="{{ old('frh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>FRH T.Base</label>
                                        <input type="number" step="0.01" name="frh_tbase" class="form-control" value="{{ old('frh_tbase') }}">
                                    </div>

                                    <!-- RLH -->
                                    <div class="form-group">
                                        <label>RLH R.Gauge</label>
                                        <input type="number" step="0.01" name="rlh_rgauge" class="form-control" value="{{ old('rlh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>RLH T.Base</label>
                                        <input type="number" step="0.01" name="rlh_tbase" class="form-control" value="{{ old('rlh_tbase') }}">
                                    </div>

                                    <!-- RRH -->
                                    <div class="form-group">
                                        <label>RRH R.Gauge</label>
                                        <input type="number" step="0.01" name="rrh_rgauge" class="form-control" value="{{ old('rrh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>RRH T.Base</label>
                                        <input type="number" step="0.01" name="rrh_tbase" class="form-control" value="{{ old('rrh_tbase') }}">
                                    </div>

                                    <!-- Picture -->
                                    <div class="form-group">
                                        <label>Picture</label>
                                        <input type="file" name="picture" class="form-control-file">
                                    </div>

                                    {{-- <!-- Resume Date -->
                                    <div class="form-group">
                                        <label>Resume Date</label>
                                        <input type="date" name="resume_date" class="form-control" value="{{ old('resume_date') }}">
                                    </div>

                                    <!-- Remark -->
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea name="remark" class="form-control">{{ old('remark') }}</textarea>
                                    </div>

                                    <!-- Resume FLH -->
                                    <div class="form-group">
                                        <label>Resume FLH R.Gauge</label>
                                        <input type="number" step="0.01" name="resume_flh_rgauge" class="form-control" value="{{ old('resume_flh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Resume FLH T.Base</label>
                                        <input type="number" step="0.01" name="resume_flh_tbase" class="form-control" value="{{ old('resume_flh_tbase') }}">
                                    </div>

                                    <!-- Resume FRH -->
                                    <div class="form-group">
                                        <label>Resume FRH R.Gauge</label>
                                        <input type="number" step="0.01" name="resume_frh_rgauge" class="form-control" value="{{ old('resume_frh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Resume FRH T.Base</label>
                                        <input type="number" step="0.01" name="resume_frh_tbase" class="form-control" value="{{ old('resume_frh_tbase') }}">
                                    </div>

                                    <!-- Resume RLH -->
                                    <div class="form-group">
                                        <label>Resume RLH R.Gauge</label>
                                        <input type="number" step="0.01" name="resume_rlh_rgauge" class="form-control" value="{{ old('resume_rlh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Resume RLH T.Base</label>
                                        <input type="number" step="0.01" name="resume_rlh_tbase" class="form-control" value="{{ old('resume_rlh_tbase') }}">
                                    </div>

                                    <!-- Resume RRH -->
                                    <div class="form-group">
                                        <label>Resume RRH R.Gauge</label>
                                        <input type="number" step="0.01" name="resume_rrh_rgauge" class="form-control" value="{{ old('resume_rrh_rgauge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Resume RRH T.Base</label>
                                        <input type="number" step="0.01" name="resume_rrh_tbase" class="form-control" value="{{ old('resume_rrh_tbase') }}">
                                    </div> --}}

                                    <!-- Submit -->
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
