@extends('layouts.app')

@section('title', 'Analisa Fuel')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    
<style>
     .status-normal {
        background-color: #95e2a7; 
    }
    .status-caution {
        background-color: #feda6d; 
    }
    .status-critical {
        background-color: #fb8d98;
    }
</style>    
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Analisa Fuel</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Tracks</div>
                    <div class="breadcrumb-item">Analisa Fuel</div>
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
                            <div class="card-header">
                                <div class="section-header-button">
                                    <a href="{{ route('analisa_fuel.create') }}" class="btn btn-primary">Add Data</a>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- Filter Form -->
                                <form method="GET" action="{{ route('analisa_fuel.index') }}">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text" class="form-control" name="customer_name" value="{{ request('customer_name') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="lab_number">Lab Number</label>
                                            <input type="text" class="form-control" name="lab_number" value="{{ request('lab_number') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="branch">Branch</label>
                                            <input type="text" class="form-control" name="branch" value="{{ request('branch') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="NORMAL" {{ request('status') == 'NORMAL' ? 'selected' : '' }}>Normal</option>
                                                <option value="CAUTION" {{ request('status') == 'CAUTION' ? 'selected' : '' }}>Caution</option>
                                                <option value="CRITICAL" {{ request('status') == 'CRITICAL' ? 'selected' : '' }}>Critical</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="sample_date">Sample Date</label>
                                            <input type="date" class="form-control" id="sample_date" name="sample_date" value="{{ request('sample_date') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="report_date">Report Date</label>
                                            <input type="date" class="form-control" id="report_date" name="report_date" value="{{ request('report_date') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="unit">Unit</label>
                                            <input type="text" class="form-control" name="unit" value="{{ request('unit') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="type_unit">Type Unit</label>
                                            <input type="text" class="form-control" name="type_unit" value="{{ request('type_unit') }}">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="serial_number">Serial Number</label>
                                            <input type="text" class="form-control" name="serial_number" value="{{ request('serial_number') }}">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-4">Filter</button>
                                    <a href="{{ route('analisa_fuel.index') }}" class="btn btn-secondary mb-4">Clear Filter</a>
                                </form>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Lab Number</th>
                                            <th>Customer Name</th>
                                            <th>Branch</th>
                                            <th>Sample Date</th>
                                            <th>Report Date</th>
                                            <th>Type Unit</th>
                                            <th>Unit</th>
                                            <th>Serial Number</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($analisa_fuels as $index => $analisa_fuel)
                                            <tr>
                                                <td>{{ $analisa_fuels->firstItem() + $index }}</td>
                                                <td class="status-{{ strtolower($analisa_fuel->status) }}">{{ ucfirst($analisa_fuel->status) }}</td>
                                                <td>{{ $analisa_fuel->lab_number }}</td>
                                                <td>{{ $analisa_fuel->customer_name }}</td>
                                                <td>{{ $analisa_fuel->branch }}</td>
                                                <td>{{ $analisa_fuel->sample_date }}</td>
                                                <td>{{ $analisa_fuel->report_date }}</td>
                                                <td>{{ $analisa_fuel->type_unit }}</td>
                                                <td>{{ $analisa_fuel->unit }}</td>
                                                <td>{{ $analisa_fuel->serial_number }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('analisa_fuel.edit', $analisa_fuel->id) }}' class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    

                                                        <form action="{{ route('analisa_fuel.destroy', $analisa_fuel->id) }}" method="POST" class="ml-2 delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="float-right">
                                    {{ $analisa_fuels->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.confirm-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            );
                        }
                    });
                });
            });
        });
    </script>
@endpush
