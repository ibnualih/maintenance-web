@extends('layouts.app')

@section('title', 'Units')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>All Units</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Units</div>
                    <div class="breadcrumb-item">Unit List</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <!-- Button to create new unit -->
                                <a href="{{ route('unit.create') }}" class="btn btn-primary">New Unit</a>

                                <!-- Form to upload Excel file -->
                                <form action="{{ route('units.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                    @csrf
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="uploadExcel" accept=".xlsx, .csv, .xls">
                                            <label class="custom-file-label" for="uploadExcel">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success">Upload Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">

                                 <!-- Form Pencarian -->
                                <div class="float-right">
                                    <form method="GET" action="{{ route('unit.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search by type or unit" name="search"
                                                value="{{ request('search') }}"> <!-- Isi otomatis saat reload -->
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Tipe Unit</th>
                                            <th>Unit</th>
                                            <th>Code Unit</th>
                                            <th>Serial Number</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($units as $unit)
                                            <tr>
                                                <td>{{ $unit->type }}</td>
                                                <td>{{ $unit->unit }}</td>
                                                <td>{{ $unit->code_unit }}</td>
                                                <td>{{ $unit->serial_number }}</td>
                                                <td>{{ $unit->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('unit.edit', $unit->id) }}" class="btn btn-info btn-sm">Edit</a>
                                                    <form action="{{ route('unit.destroy', $unit->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $units->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || "Choose file";
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>

@endsection

@push('scripts')
<script>
    handleDelete('.btn-delete'); // Memanggil fungsi global untuk tombol dengan class .btn-delete
</script>
@endpush
