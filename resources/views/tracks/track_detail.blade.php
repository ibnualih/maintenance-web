@extends('layouts.app')

@section('title', 'Status Tracks')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>HEALTH SCORE TRACKS ENGINE</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Dashboard</div>
                    <div class="breadcrumb-item">Phenomena</div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 text-center">
                    <h3>CAUTION</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>UNIT MODEL</th>
                                <th>UNIT CODE</th>
                                <th>TOTAL PHENOMENA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="table-warning text-center">Tidak ada data caution.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6 text-center">
                    <h3>CRITICAL</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>UNIT MODEL</th>
                                <th>UNIT CODE</th>
                                <th>TOTAL PHENOMENA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="table-danger text-center">Tidak ada data critical.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
