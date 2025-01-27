@extends('layouts.app')

@section('title', 'Create Magnetic Pluck')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Create Magnetic Pluck</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('magnetic_plucks.index') }}">Magnetic Plug</a></div>
                <div class="breadcrumb-item active">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('magnetic_plucks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="unit_model">Unit Model</label>
                            <select name="unit_model" id="unit_model" class="form-control" required>
                                <option value="">Select Unit Model</option>
                                @foreach ($unitModels as $unit)
                                    <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="unit_code">Unit Code</label>
                            <select name="unit_code" id="unit_code" class="form-control" required>
                                <option value="">Select Unit Code</option>
                                <!-- Options akan diisi secara dinamis -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hm">HM</label>
                            <input type="number" name="hm" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="last_update">Last Update</label>
                            <input type="date" name="last_update" id="last_update" class="form-control" placeholder="select date" required>
                        </div>

                        <div class="form-group">
                            <label for="component">Component</label>
                            <select name="component" id="component" class="form-control" required>
                                <option value="">Select component</option>
                                <!-- Options akan diisi secara dinamis -->
                            </select>
                            {{-- <label for="component">Component</label>
                            <input type="text" name="component" class="form-control" required> --}}
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option value="">Select rating</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="x">X</option>
                                <option value="xxx">XXX</option>
                                <!-- Options akan diisi secara dinamis -->
                            </select>
                        {{--  <label for="rating">Rating</label>
                            <input type="text" name="rating" class="form-control" required> --}}
                        </div>

                        <div class="form-group">
                            <label for="picture">Picture</label>
                            <small class="text-muted">Max size: 2Mb</small>
                            <input type="file" name="picture" class="form-control form-control-file">
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('magnetic_plucks.index') }}" class="btn btn-secondary">Cancel</a>
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
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const unitModelSelect = document.getElementById('unit_model');
    const unitCodeSelect = document.getElementById('unit_code');
    const componentSelect = document.getElementById('component');

    const componentsMap = {
        'PC2000-8': ['Final Drive LH', 'Final Drive RH'],
        'PC1250-8': ['Final Drive LH', 'Final Drive RH'],
        'PC850-8': ['Final Drive LH', 'Final Drive RH'],
        'D155-6R': ['Final Drive LH', 'Final Drive RH'],
        'HD785-7': ['Final Drive LH', 'Final Drive RH', 'Differential'],
        'GD825-2': ['Differential'],
        'GD755-5': ['Differential'],
    };

    unitModelSelect.addEventListener('change', function () {
        const selectedModel = this.value;

        // Reset and disable dropdowns
        unitCodeSelect.innerHTML = '<option value="">-- Select Unit Code --</option>';
        componentSelect.innerHTML = '<option value="">-- Select Component --</option>';
        unitCodeSelect.disabled = true;
        componentSelect.disabled = true;

        if (!selectedModel) return;

        // Fetch unit codes based on selected model
        fetch(`/get-unit-codes/${selectedModel}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch unit codes');
                }
                return response.json();
            })
            .then(data => {
                if (data.unitCodes.length > 0) {
                    unitCodeSelect.disabled = false;
                    data.unitCodes.forEach(function (code) {
                        const option = document.createElement('option');
                        option.value = code;
                        option.textContent = code;
                        unitCodeSelect.appendChild(option);
                    });
                }

                if (componentsMap[selectedModel]) {
                    componentSelect.disabled = false;
                    componentsMap[selectedModel].forEach(function (component) {
                        const option = document.createElement('option');
                        option.value = component;
                        option.textContent = component;
                        componentSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching unit codes:', error);
                alert('Failed to fetch unit codes. Please try again.');
            });
    });
});
</script>
@endpush
