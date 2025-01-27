@extends('layouts.app')

@section('title', 'Edit Swing Circle')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Swing Circle</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Swing Circles</div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>
            <div class="section-body">
                <div class="card">
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

                        <form action="{{ route('swing_circles.update', $swingCircle->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="unit_model">Unit Model</label>
                                <select name="unit_model" id="unit_model" class="form-control">
                                    <option value="" selected disabled>Select Unit Model</option>
                                    @foreach ($unitModels as $id => $model)
                                        <option value="{{ $model }}" {{ $model == $swingCircle->unit_model ? 'selected' : '' }}>
                                            {{ $model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="unit_code">Unit Code</label>
                                <select name="unit_code" id="unit_code" class="form-control">
                                    <option value="" selected disabled>Select Unit Code</option>
                                    @foreach ($allUnits as $unit)
                                        @if ($unit->unit === $swingCircle->unit_model)
                                            <option value="{{ $unit->code_unit }}" {{ $unit->code_unit == $swingCircle->unit_code ? 'selected' : '' }}>
                                                {{ $unit->code_unit }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="hm">HM</label>
                                <input type="number" name="hm" id="hm" value="{{ $swingCircle->hm }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="last_update">Last Update</label>
                                <input type="text" name="last_update" id="last_update" class="form-control"
                                value="{{ old('last_update', $swingCircle->last_update) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="peak_value">Peak Value</label>
                                <input type="number" step="0.01" name="peak_value" id="peak_value" value="{{ $swingCircle->peak_value }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="front_value">Front Value</label>
                                <input type="number" step="0.01" name="front_value" id="front_value" value="{{ $swingCircle->front_value }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="front_picture">Front Picture</label>
                                <input type="file" name="front_picture" id="front_picture" class="form-control">
                                @if ($swingCircle->front_picture)
                                    <p>Current Picture: <a href="{{ asset('storage/' . $swingCircle->front_picture) }}" target="_blank">View</a></p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="rear_value">Rear Value</label>
                                <input type="number" step="0.01" name="rear_value" id="rear_value" value="{{ $swingCircle->rear_value }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="rear_picture">Rear Picture</label>
                                <input type="file" name="rear_picture" id="rear_picture" class="form-control">
                                @if ($swingCircle->rear_picture)
                                    <p>Current Picture: <a href="{{ asset('storage/' . $swingCircle->rear_picture) }}" target="_blank">View</a></p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="level_grease_picture">Level Grease Picture</label>
                                <input type="file" name="level_grease_picture" id="level_grease_picture" class="form-control">
                                @if ($swingCircle->level_grease_picture)
                                    <p>Current Picture: <a href="{{ asset('storage/' . $swingCircle->level_grease_picture) }}" target="_blank">View</a></p>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('swing_circles.index') }}" class="btn btn-secondary">Back</a>
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

    document.addEventListener('DOMContentLoaded', function () {
        const allUnits = @json($allUnits);

        document.getElementById('unit_model').addEventListener('change', function () {
            const selectedModel = this.value;
            const unitCodeSelect = document.getElementById('unit_code');

            unitCodeSelect.innerHTML = '<option value="" disabled selected>Select Unit Code</option>';

            allUnits.forEach(unit => {
                if (unit.unit === selectedModel) {
                    const option = document.createElement('option');
                    option.value = unit.code_unit;
                    option.textContent = unit.code_unit;
                    unitCodeSelect.appendChild(option);
                }
            });
        });
    });
</script>
@endpush
