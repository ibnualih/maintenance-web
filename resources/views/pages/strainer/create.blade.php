@extends('layouts.app')

@section('title', 'Add Strainer')

@push('style')
    <!-- Tambahkan CSS Libraries jika perlu -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Create Strainer</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('strainer.index') }}">Strainer</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>New Strainer Data</h4>
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

                    <form action="{{ route('strainer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="unit_model">Unit Model</label>
                            <select name="unit_model" id="unit_model" class="form-control" required>
                                <option value="">Select Unit Model</option>
                                @foreach ($unitModels as $model)
                                    <option value="{{ $model->unit }}">{{ $model->unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="unit_code">Unit Code</label>
                            <select name="unit_code" id="unit_code" class="form-control" required>
                                <option value="">Select Unit Code</option>
                                <!-- Unit Code options akan diisi secara dinamis oleh JavaScript -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hm">HM</label>
                            <input type="number" name="hm" id="hm" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="last_update">Last Update</label>
                            <input type="date" name="last_update" id="last_update" class="form-control" placeholder="select date" required>
                        </div>

                        <div class="form-group">
                            <label for="component">Component</label>
                            <input type="text" name="component" id="component" class="form-control" value="Transmission" readonly>
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
                        </div>

                        <div class="form-group">
                            <label for="picture">Picture</label>
                            <input type="file" name="picture" id="picture" class="form-control">
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('strainer.index') }}" class="btn btn-secondary">Cancel</a>
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

    // Data unit yang dikirim dari controller, digunakan untuk filtering unit_code berdasarkan unit_model
    const allUnits = @json($allUnits);

    document.addEventListener("DOMContentLoaded", function() {
        const unitModelSelect = document.getElementById("unit_model");
        const unitCodeSelect = document.getElementById("unit_code");

        // Event listener untuk perubahan di dropdown unit_model
        unitModelSelect.addEventListener("change", function() {
            const selectedModel = this.value;

            // Hapus semua opsi dari dropdown unit_code
            unitCodeSelect.innerHTML = '<option value="">Select Unit Code</option>';

            // Filter unit_code berdasarkan unit_model yang dipilih
            const filteredUnits = allUnits.filter(unit => unit.unit === selectedModel);

            // Tambahkan opsi yang sesuai ke dropdown unit_code
            filteredUnits.forEach(unit => {
                const option = document.createElement("option");
                option.value = unit.code_unit;
                option.textContent = unit.code_unit;
                unitCodeSelect.appendChild(option);
                // console.log("Response Data:", data);
            });
        });
    });
</script>
@endpush
