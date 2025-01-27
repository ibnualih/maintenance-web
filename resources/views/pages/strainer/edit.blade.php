@extends('layouts.app')

@section('title', 'Edit Strainer')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Strainer</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item">Strainer</div>
                    <div class="breadcrumb-item active">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Strainer Data</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                @endif
                                <form action="{{ route('strainer.update', $strainer->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="unit_model">Unit Model</label>
                                        <select name="unit_model" id="unit_model" class="form-control">
                                            <option value="">Select Unit Model</option>
                                            @foreach ($unitModels as $unit)
                                                <option value="{{ $unit->unit }}" {{ $unit->unit === $strainer->unit_model ? 'selected' : '' }}>
                                                    {{ $unit->unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="unit_code">Unit Code</label>
                                        <select name="unit_code" id="unit_code" class="form-control">
                                            <option value="">Select Unit Code</option>
                                            @foreach ($allUnits as $unit)
                                                @if ($unit->unit === $strainer->unit_model)
                                                    <option value="{{ $unit->code_unit }}" {{ $unit->code_unit === $strainer->unit_code ? 'selected' : '' }}>
                                                        {{ $unit->code_unit }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="hm">HM</label>
                                        <input type="number" name="hm" class="form-control" value="{{ $strainer->hm }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="last_update">Last Update</label>
                                        <input type="text" id="last_update" name="last_update" class="form-control"
                                        value="{{ old('last_update', $strainer->last_update) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="component">Component</label>
                                        <input type="text" name="component" class="form-control" value="{{ $strainer->component }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                        <input type="text" name="rating" class="form-control" value="{{ $strainer->rating }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="picture">Picture</label>
                                        <input type="file" name="picture" class="form-control-file">
                                        @if ($strainer->picture)
                                            <p>Current Picture: <a href="{{ asset('storage/' . $strainer->picture) }}" target="_blank">View</a></p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('cutting_filters.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
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
        flatpickr("#last_update", {
            dateFormat: "d-m-Y", // Format tanggal
            allowInput: true, // Memungkinkan pengguna mengetik manual
            defaultDate: document.getElementById('last_update').value // Set default date
        });
    });
</script>
@endpush
