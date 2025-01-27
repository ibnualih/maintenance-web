@extends('layouts.app')

@section('title', 'Wheel Brake Resume & Chart')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Wheel Brake Resume & Chart</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('wheel-brakes.index') }}">Wheel Brake</a></div>
                <div class="breadcrumb-item">Resume & Chart</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <h1 class="mb-4">Resume Wheel Brakes (Approved Only)</h1> --}}
                        <table class="table table-striped text-center align-middle custom-table">
                            <thead class="custom-header">
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">Unit Code</th>
                                    <th rowspan="3">HM</th>
                                    <th rowspan="3">
                                        ED
                                        <a href="{{ route('wheel-brakes.index', array_merge(request()->all(), ['sort_ed' => 'asc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-down"></i>
                                        </a>
                                        <a href="{{ route('wheel-brakes.index', array_merge(request()->all(), ['sort_ed' => 'desc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-up"></i>
                                        </a>
                                    </th>
                                    <th colspan="10">Last</th>
                                    <th rowspan="3">Submitted By</th>
                                </tr>
                                <tr>
                                    <th rowspan="2">Date</th>
                                    <th colspan="2">FLH</th>
                                    <th colspan="2">FRH</th>
                                    <th colspan="2">RLH</th>
                                    <th colspan="2">RRH</th>
                                    <th rowspan="2">Picture</th>
                                </tr>
                                <tr>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedData as $wheelBrake)
                                    <tr>
                                        <td>{{ $startNumber + $loop->iteration }}</td>
                                        <td>{{ $wheelBrake->unit_code }}</td>
                                        <td>{{ $wheelBrake->hm }}</td>
                                        <td>
                                            {{ $wheelBrake->last_date ? \Carbon\Carbon::parse($wheelBrake->last_date)->diffInDays(now()) : 'N/A' }} days
                                        </td>
                                        <td>{{ $wheelBrake->last_date }}</td>
                                        <td>{{ $wheelBrake->flh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->flh_tbase ?? '-' }}</td>
                                        <td>{{ $wheelBrake->frh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->frh_tbase ?? '-' }}</td>
                                        <td>{{ $wheelBrake->rlh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->rlh_tbase ?? '-' }}</td>
                                        <td>{{ $wheelBrake->rrh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->rrh_tbase ?? '-' }}</td>
                                        <td>
                                            @if ($wheelBrake->picture)
                                                <a href="#" data-toggle="modal" data-target="#pictureModal{{ $wheelBrake->id }}">
                                                    <img src="{{ asset('storage/' . $wheelBrake->picture) }}" alt="Picture" width="50" style="cursor: pointer;">
                                                </a>                                                        @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>{{ $wheelBrake->user->name ?? 'Unknown' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="text-center">No Data Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $approvedData->links() }}
                        </div>
                    </div>

                </div>
            </div>
            {{-- <div class="card">
                <div class="row">
                    <!-- Section for Summary Cards -->
                    @foreach ($ratingSummary as $rating => $count)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Rating {{ $rating }}</h5>
                                    <p class="card-text">
                                        <span class="badge badge-primary" style="font-size: 1.2rem;">
                                            {{ $count }} Items
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Section for Chart -->
                <div class="row">
                    @foreach ($charts as $unitModel => $chart)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ $unitModel }}</h4>
                                </div>
                                <div class="card-body">
                                    {!! $chart->container() !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
        </div>
    </section>
</div>

@foreach ($approvedData as $wheelBrake)
    @include('modals.picture_modal', ['image' => $wheelBrake->picture, 'modalId' => 'pictureModal' . $wheelBrake->id])
@endforeach

{{-- @include('modals.filter_component') --}}

@push('scripts')
    {{-- Include Chart Script --}}
    {{-- @foreach ($charts as $chart)
        {!! $chart->script() !!}
    @endforeach --}}
@endpush
@endsection
