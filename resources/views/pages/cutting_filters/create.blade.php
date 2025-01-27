@extends('layouts.app')

@section('title', 'Create Cutting Filter')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Cutting Filter</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('cutting_filters.index') }}">Cutting Filters</a></div>
                    <div class="breadcrumb-item active">Create</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>New Cutting Filter Data</h4>
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

                        <form action="{{ route('cutting_filters.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="unit_model">Unit Model</label>
                                <select name="unit_model" id="unit_model" class="form-control" required>
                                    <option value="">Select Unit Model</option>
                                    @foreach ($unitModels as $unit)
                                        <option value="{{ $unit->unit }}" {{ old('unit_model') == $unit->unit ? 'selected' : '' }}>
                                            {{ $unit->unit }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_model')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="unit_code">Unit Code</label>
                                <select name="unit_code" id="unit_code" class="form-control" required>
                                    <option value="">Select Unit Code</option>
                                    <!-- Options will be dynamically loaded -->
                                </select>
                                @error('unit_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="hm">HM</label>
                                <input type="number" name="hm" id="hm" class="form-control" required>
                                @error('hm')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_update">Last Update</label>
                                <input type="date" name="last_update" id="last_update" class="form-control" placeholder="select date" required>
                                @error('last_update')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="component">Component</label>
                                <input type="text" name="component" id="component" class="form-control" value="Engine" readonly>
                            </div>

                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" id="rating" class="form-control" required>
                                    <option value="">Select Rating</option>
                                    <option value="a" {{ old('rating') == 'a' ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ old('rating') == 'b' ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ old('rating') == 'c' ? 'selected' : '' }}>C</option>
                                    <option value="x" {{ old('rating') == 'x' ? 'selected' : '' }}>X</option>
                                    <option value="xxx" {{ old('rating') == 'xxx' ? 'selected' : '' }}>XXX</option>
                                </select>
                                @error('rating')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="picture">Picture</label>
                                <input type="file" name="picture" id="picture" class="form-control">
                                @error('picture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
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
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
    const unitModelSelect = document.getElementById('unit_model');
    const unitCodeSelect = document.getElementById('unit_code');

    unitModelSelect.addEventListener('change', function () {
        const selectedModel = this.value;

        // Reset dropdown unit_code
        unitCodeSelect.innerHTML = '<option value="">-- Select Unit Code --</option>';
        unitCodeSelect.disabled = true;

        if (!selectedModel) return;

        // Fetch unit codes from server
        fetch(`/get-unit-codes/${selectedModel}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Check if unit codes are available
                if (data.unitCodes && data.unitCodes.length > 0) {
                    unitCodeSelect.disabled = false;
                    data.unitCodes.forEach(code => {
                        const option = document.createElement('option');
                        option.value = code;
                        option.textContent = code;
                        unitCodeSelect.appendChild(option);
                    });
                } else {
                    unitCodeSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error fetching unit codes:', error);
                alert('Failed to fetch unit codes. Please try again later.');
            });
    });
});

</script>
@endpush
