@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <!-- Summary Cards Row -->
            @role(['admin', 'supervisor'])
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="text-primary">{{ $totalUsers }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Units</h5>
                            <h2 class="text-primary">{{ $totalUnits }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            @endrole

            <!-- Maintenance Menu Section -->
            <div class="row">
                <div class="card container text-center">
                    <h3 class="mb-4" style="margin-top: 1em">Component Menu</h3>
                    <p class="mb-5">klik tombol dibawah sesuai komponen yang ingin dilihat detailnya</p>

                    <div class="row g-4">
                        <!-- Menu Cards -->
                        @php
                            $menus = [
                                ['title' => 'Magnetic Plug', 'link' => 'cbm/magnetic_plucks/create'],
                                ['title' => 'Cutting Filter', 'link' => 'cbm/cutting_filters/create'],
                                ['title' => 'Strainer', 'link' => 'cbm/strainer/create'],
                                ['title' => 'Swing Circle', 'link' => 'cbm/swing_circles/create'],
                                ['title' => 'Wheel Brake', 'link' => 'cbm/wheel-brakes/create'],
                            ];
                        @endphp
                        @foreach ($menus as $menu)
                            <div class="col-md-4">
                                <div class="card menu-card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $menu['title'] }}</h5>
                                        <a href="{{ $menu['link'] }}" class="btn btn-primary">Akses Menu</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mt-5">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Unit</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tipe Unit</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                {!! $unitChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Load Chart Script -->
    <script src="{{ LarapexChart::cdn() }}"></script>
    {{ $chart->script() }}
    {{ $unitChart->script() }}
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
