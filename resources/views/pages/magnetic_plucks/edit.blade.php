@extends('layouts.app')

@section('title', 'Edit Magnetic Pluck')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Magnetic Plug</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Maintenance</div>
                <div class="breadcrumb-item">Magnetic Plug</div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Magnetic Plug Data</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('magnetic_plucks.update', $magneticPluck->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="unit_model">Unit Model</label>
                                    <select name="unit_model" id="unit_model" class="form-control">
                                        <option value="">Select Unit Model</option>
                                        @foreach ($unitModels as $unit)
                                            <option value="{{ $unit->unit }}" {{ $unit->unit === $magneticPluck->unit_model ? 'selected' : '' }}>
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
                                            @if ($unit->unit === $magneticPluck->unit_model)
                                                <option value="{{ $unit->code_unit }}" {{ $unit->code_unit === $magneticPluck->unit_code ? 'selected' : '' }}>
                                                    {{ $unit->code_unit }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="hm">HM</label>
                                    <input type="number" name="hm" class="form-control" value="{{ $magneticPluck->hm }}" required>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="ed">ED</label>
                                    <input type="number" name="ed" class="form-control" value="{{ $magneticPluck->ed }}" required>
                                </div> --}}

                                <div class="form-group">
                                    <label for="last_update">Last Update</label>
                                    <input type="text" name="last_update" id="last_update" class="form-control"
                                    value="{{ old('last_update', $magneticPluck->last_update) }}"
                                    required>
                                </div>

                                <div class="form-group">
                                    <label for="component">Component</label>
                                    <input type="text" name="component" class="form-control" value="{{ $magneticPluck->component }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <input type="text" name="rating" class="form-control" value="{{ $magneticPluck->rating }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="picture">Picture</label>
                                    <input type="file" name="picture" class="form-control-file">
                                    @if ($magneticPluck->picture)
                                        <p>Current Picture: <a href="{{ asset('storage/' . $magneticPluck->picture) }}" target="_blank">View</a></p>
                                    @endif
                                </div>

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
        flatpickr("#last_update", {
            dateFormat: "d-m-Y", // Format tanggal
            allowInput: true, // Memungkinkan pengguna mengetik manual
            defaultDate: document.getElementById('last_update').value // Set default date
        });
    });

    const allUnits = @json($allUnits);

    document.getElementById('unit_model').addEventListener('change', function() {
        const selectedModel = this.value;
        const unitCodeDropdown = document.getElementById('unit_code');

        // Clear existing options
        unitCodeDropdown.innerHTML = '<option value="">Select Unit Code</option>';

        // Filter and add options dynamically
        allUnits.forEach(unit => {
            if (unit.unit === selectedModel) {
                const option = document.createElement('option');
                option.value = unit.code_unit;
                option.textContent = unit.code_unit;
                unitCodeDropdown.appendChild(option);
            }
        });
    });
</script>
@endpush
