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
            dateFormat: "d-m-Y",
            allowInput: true,
            defaultDate: document.getElementById('last_update').value
        });
    });

    const allUnits = @json($allUnits);

    document.addEventListener("DOMContentLoaded", function() {
        const unitModelSelect = document.getElementById("unit_model");
        const unitCodeSelect = document.getElementById("unit_code");
        const componentSelect = document.getElementById("component");

        const componentsMap = {
            'PC2000-8': ['Final Drive LH', 'Final Drive RH'],
            'PC1250-8': ['Final Drive LH', 'Final Drive RH'],
            'PC850-8': ['Final Drive LH', 'Final Drive RH'],
            'D155-6R': ['Final Drive LH', 'Final Drive RH'],
            'HD785-7': ['Final Drive LH', 'Final Drive RH', 'Differential'],
            'GD825-2': ['Differential'],
            'GD755-5': ['Differential'],
        };

        unitModelSelect.addEventListener("change", function() {
            const selectedModel = this.value;
            unitCodeSelect.innerHTML = '<option value="">Select Unit Code</option>';
            componentSelect.innerHTML = '<option value="">Select Component</option>';

            const filteredUnits = allUnits.filter(unit => unit.unit === selectedModel);
            filteredUnits.forEach(unit => {
                const option = document.createElement("option");
                option.value = unit.code_unit;
                option.textContent = unit.code_unit;
                unitCodeSelect.appendChild(option);
            });

            if (componentsMap[selectedModel]) {
                componentsMap[selectedModel].forEach(component => {
                    const option = document.createElement("option");
                    option.value = component;
                    option.textContent = component;
                    componentSelect.appendChild(option);
                });
            }
        });
    });
</script>
@endpush
