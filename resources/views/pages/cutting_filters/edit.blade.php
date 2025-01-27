@extends('layouts.app')

@section('title', 'Edit Cutting Filter')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Cutting Filter</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('cutting_filters.index') }}">Cutting Filters</a>
                </div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Update Cutting Filter Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cutting_filters.update', $cuttingFilter->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="unit_model">Unit Model</label>
                            <select name="unit_model" id="unit_model" class="form-control">
                                <option value="">Select Unit Model</option>
                                @foreach ($unitModels as $unit)
                                    <option value="{{ $unit->unit }}" {{ $unit->unit === $cuttingFilter->unit_model ? 'selected' : '' }}>
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
                                    @if ($unit->unit === $cuttingFilter->unit_model)
                                        <option value="{{ $unit->code_unit }}" {{ $unit->code_unit === $cuttingFilter->unit_code ? 'selected' : '' }}>
                                            {{ $unit->code_unit }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hm">HM</label>
                            <input type="number" name="hm" class="form-control" value="{{ $cuttingFilter->hm }}" required>
                        </div>

                        <div class="form-group">
                            <label for="last_update">Last Update</label>
                            <input type="text" id="last_update" name="last_update" class="form-control"
                            value="{{ old('last_update', $cuttingFilter->last_update) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="component">Component</label>
                            <input type="text" name="component" class="form-control" value="{{ $cuttingFilter->component }}" required>
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <input type="text" name="rating" class="form-control" value="{{ $cuttingFilter->rating }}" required>
                        </div>

                        <div class="form-group">
                            <label for="picture">Picture</label>
                            <input type="file" name="picture" class="form-control-file">
                            @if ($cuttingFilter->picture)
                                <p>Current Picture: <a href="{{ asset('storage/' . $cuttingFilter->picture) }}" target="_blank">View</a></p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('cutting_filters.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
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
