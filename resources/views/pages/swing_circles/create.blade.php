@extends('layouts.app')

@section('title', 'Add Swing Circle')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Swing Circle</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('swing_circles.index') }}">Swing Circle</a></div>
                    <div class="breadcrumb-item">Add</div>
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('swing_circles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="unit_model">Unit Model</label>
                                <select name="unit_model" id="unit_model" class="form-control" required>
                                    <option value="" selected disabled>Select Unit Model</option>
                                    @foreach ($unitModels as $unitModel)
                                        <option value="{{ $unitModel->unit }}">{{ $unitModel->unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="unit_code">Unit Code</label>
                                <select name="unit_code" id="unit_code" class="form-control" required>
                                    <option value="" selected disabled>Select Unit Code</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="hm">HM</label>
                                <input type="number" name="hm" id="hm" class="form-control" required>
                            </div>

                            {{-- <div class="form-group">
                                <label for="ed">ED</label>
                                <input type="hidden" name="ed" id="ed" class="form-control" required>
                                <input type="text" id="ed_display" class="form-control" disabled>
                            </div> --}}

                            <div class="form-group">
                                <label for="last_update">Last Update</label>
                                <input type="text" name="last_update" id="last_update" class="form-control" placeholder="select date" required>
                            </div>

                            <div class="form-group">
                                <label for="peak_value">Peak Value</label>
                                <input type="number" step="0.01" name="peak_value" id="peak_value" class="form-control" placeholder="Gunakan '.' jika bilangan desimal contoh: 0.1" required>
                            </div>

                            <div class="form-group">
                                <label for="front_value">Front Value</label>
                                <input type="number" step="0.01" name="front_value" id="front_value" class="form-control" placeholder="Gunakan '.' jika bilangan desimal contoh: 0.1"required>
                            </div>

                            <div class="form-group">
                                <label for="front_picture">Front Picture</label>
                                <input type="file" name="front_picture" id="front_picture" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="rear_value">Rear Value</label>
                                <input type="number" step="0.01" name="rear_value" id="rear_value" class="form-control" placeholder="Gunakan '.' jika bilangan desimal contoh: 0.1" required>
                            </div>

                            <div class="form-group">
                                <label for="rear_picture">Rear Picture</label>
                                <input type="file" name="rear_picture" id="rear_picture" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="level_grease_picture">Level Grease Picture</label>
                                <input type="file" name="level_grease_picture" id="level_grease_picture" class="form-control">
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('swing_circles.index') }}" class="btn btn-secondary">Back</a>
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

    document.addEventListener('DOMContentLoaded', function () {
        const allUnits = @json($allUnits); // Semua data unit bertipe 'Exca'

        // Event listener untuk perubahan dropdown Unit Model
        document.getElementById('unit_model').addEventListener('change', function () {
            const selectedModel = this.value; // Unit Model yang dipilih
            const unitCodeSelect = document.getElementById('unit_code'); // Dropdown Unit Code

            // Reset opsi dropdown Unit Code
            unitCodeSelect.innerHTML = '<option value="" disabled selected>Select Unit Code</option>';

            // Filter data berdasarkan Unit Model yang dipilih
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

