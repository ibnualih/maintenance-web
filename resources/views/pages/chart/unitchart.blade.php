@extends('layouts.app')

@section('title', 'Unit Charts')

@section('main')
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1>Unit Charts</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Chart 1: Type Distribution -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pie Chart: Unit Types</h4>
                        </div>
                        <div class="card-body">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Unit Distribution -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pie Chart: Unit Models</h4>
                        </div>
                        <div class="card-body">
                            {!! $unitChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart Script -->
<script src="{{ LarapexChart::cdn() }}"></script>
{{ $chart->script() }}
{{ $unitChart->script() }}
@endsection
