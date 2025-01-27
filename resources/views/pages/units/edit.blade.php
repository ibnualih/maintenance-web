@extends('layouts.app')

@section('title', 'Edit Unit')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Unit</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('unit.index') }}">Units</a></div>
                    <div class="breadcrumb-item">Edit Unit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('unit.update', $unit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit Unit</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control" name="type" value="{{ $unit->type }}" required>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" name="unit" value="{{ $unit->unit }}" required>
                            </div>
                            <div class="form-group">
                                <label>Code Unit</label>
                                <input type="text" class="form-control" name="code_unit" value="{{ $unit->code_unit }}" required>
                            </div>
                            <div class="form-group">
                                <label>Serial Number</label>
                                <input type="text" class="form-control" name="serial_number" value="{{ $unit->serial_number }}" required>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Update Unit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
