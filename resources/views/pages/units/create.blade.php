@extends('layouts.app')

@section('title', 'Add New Unit')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add New Unit</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('unit.index') }}">Units</a></div>
                    <div class="breadcrumb-item">Add New Unit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('unit.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>New Unit</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control" name="type" required>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" name="unit" required>
                            </div>
                            <div class="form-group">
                                <label>Code Unit</label>
                                <input type="text" class="form-control" name="code_unit" required>
                            </div>
                            <div class="form-group">
                                <label>Serial Number</label>
                                <input type="text" class="form-control" name="serial_number" required>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Save Unit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
