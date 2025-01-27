@extends('layouts.app')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Upload Unit Data</h1>
            </div>
            <div class="section-body">
                <form action="{{ route('unit.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Upload Excel File</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </section>
    </div>
@endsection
