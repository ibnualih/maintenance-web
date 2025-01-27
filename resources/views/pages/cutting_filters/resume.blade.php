@extends('layouts.app')

@section('title', 'Cutting Filter Resume & Chart')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Cutting Filter Resume & Chart</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('cutting_filters.index') }}">Cutting Filter</a></div>
                <div class="breadcrumb-item">Resume & Chart</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('cutting_filters.create') }}" class="btn btn-primary">New Cutting Filter</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <h1 class="mb-4">Resume Cutting Filters (Approved Only)</h1> --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Model</th>
                                    <th>Unit Code</th>
                                    <th>HM</th>
                                    <th>ED
                                        <a href="{{ route('cutting_filters.index', array_merge(request()->all(), ['sort_ed' => 'asc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-down"></i>
                                        </a>
                                        <a href="{{ route('cutting_filters.index', array_merge(request()->all(), ['sort_ed' => 'desc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-up"></i>
                                        </a>
                                    </th>
                                    <th>Last Update</th>
                                    <th>Component
                                        <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#filterComponentModal">
                                            <i class="fas fa-filter"></i>
                                        </button>
                                    </th>
                                    <th>Rating</th>
                                    <th>Picture</th>
                                    <th>Submitted By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedData as $filter)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
                                        <td>{{ $filter->unit_model }}</td>
                                        <td>{{ $filter->unit_code }}</td>
                                        <td>{{ $filter->hm }}</td>
                                        <td>
                                            {{ $filter->last_update ? \Carbon\Carbon::parse($filter->last_update)->diffInDays(now()) : 'N/A' }} days
                                        </td>
                                        <td>{{ $filter->last_update }}</td>
                                        <td>{{ $filter->component }}</td>
                                        <td>{{ $filter->rating }}</td>
                                        <td>
                                            @if ($filter->picture)
                                            <a href="#" data-toggle="modal" data-target="#pictureModal{{ $filter->id }}">
                                                <img src="{{ asset('storage/' . $filter->picture) }}" alt="Picture" width="50" style="cursor: pointer;">
                                            </a>
                                            @else
                                            <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>{{ $filter->user->name ?? 'Unknown' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No approved data available.</td>
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
            <div class="card">
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
            </div>
        </div>
    </section>
</div>

@foreach ($approvedData as $filter)
    @include('modals.picture_modal', ['image' => $filter->picture, 'modalId' => 'pictureModal' . $filter->id])
@endforeach

@include('modals.filter_component')

@push('scripts')
    {{-- Include Chart Script --}}
    @foreach ($charts as $chart)
        {!! $chart->script() !!}
    @endforeach
@endpush
@endsection
