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
                    <form method="GET" action="{{ route('wheel-brakes.resume') }}" class="mb-3">
                        <div class="form-row">
                            <div class="col-md-4">
                                <input type="text" name="unit_code" class="form-control" placeholder="Search Unit Code" value="{{ request('unit_code') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('wheel-brakes.resume') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        {{-- <h1 class="mb-4">Resume Wheel Brakes (Approved Only)</h1> --}}
                        <table class="table table-striped text-center align-middle custom-table">
                            <thead class="custom-header">
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">Unit Code</th>
                                    <th rowspan="3">HM</th>
                                    <th rowspan="3">ED
                                        <a href="{{ route('wheel-brakes.resume', array_merge(request()->all(), ['sort_ed' => 'asc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-down"></i>
                                        </a>
                                        <a href="{{ route('wheel-brakes.resume', array_merge(request()->all(), ['sort_ed' => 'desc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-up"></i>
                                        </a>
                                    </th>
                                    <th colspan="13">Last</th>
                                    <th rowspan="3">Submitted By</th>
                                </tr>
                                <tr>
                                    <th rowspan="2">Date</th>
                                    <th colspan="3">FLH</th>
                                    <th colspan="3">FRH</th>
                                    <th colspan="3">RLH</th>
                                    <th colspan="3">RRH</th>
                                </tr>
                                <tr>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">Picture</th>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">Picture</th>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">Picture</th>
                                    <th colspan="1">R.Gauge</th>
                                    <th colspan="1">T.Base</th>
                                    <th colspan="1">Picture</th>
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
                                        <!-- FLH -->
                                        <td>{{ $wheelBrake->flh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->flh_tbase ?? '-' }}</td>
                                        <td>
                                            @if ($wheelBrake->llh_picture)
                                                <a href="#" data-toggle="modal" data-target="#flh{{ $wheelBrake->id }}">
                                                    <img src="{{ asset('storage/' . $wheelBrake->llh_picture) }}" alt="FLH Picture" width="50" style="cursor: pointer;">
                                                </a>
                                            @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <!-- FRH -->
                                        <td>{{ $wheelBrake->frh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->frh_tbase ?? '-' }}</td>
                                        <td>
                                            @if ($wheelBrake->lrh_picture)
                                                <a href="#" data-toggle="modal" data-target="#frh{{ $wheelBrake->id }}">
                                                    <img src="{{ asset('storage/' . $wheelBrake->lrh_picture) }}" alt="FRH Picture" width="50" style="cursor: pointer;">
                                                </a>
                                            @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <!-- RLH -->
                                        <td>{{ $wheelBrake->rlh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->rlh_tbase ?? '-' }}</td>
                                        <td>
                                            @if ($wheelBrake->rlh_picture)
                                                <a href="#" data-toggle="modal" data-target="#rlh{{ $wheelBrake->id }}">
                                                    <img src="{{ asset('storage/' . $wheelBrake->rlh_picture) }}" alt="RLH Picture" width="50" style="cursor: pointer;">
                                                </a>
                                            @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <!-- RRH -->
                                        <td>{{ $wheelBrake->rrh_rgauge ?? '-' }}</td>
                                        <td>{{ $wheelBrake->rrh_tbase ?? '-' }}</td>
                                        <td>
                                            @if ($wheelBrake->picture)
                                                <a href="#" data-toggle="modal" data-target="#pictureModal{{ $wheelBrake->id }}">
                                                    <img src="{{ asset('storage/' . $wheelBrake->picture) }}" alt="Picture" width="50" style="cursor: pointer;">
                                                </a>
                                            @else
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
        </div>
    </section>
</div>

@foreach ($approvedData as $wheelBrake)
@include('modals.picture_modal', ['image' => $wheelBrake->llh_picture, 'modalId' => 'flh' . $wheelBrake->id])
@include('modals.picture_modal', ['image' => $wheelBrake->lrh_picture, 'modalId' => 'frh' . $wheelBrake->id])
@include('modals.picture_modal', ['image' => $wheelBrake->rlh_picture, 'modalId' => 'rlh' . $wheelBrake->id])
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
