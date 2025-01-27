@extends('layouts.app')

@section('title', 'Magnetic Plug Resume & Chart')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Magnetic Plug Resume & Chart</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('magnetic_plucks.index') }}">Magnetic Plug</a></div>
                <div class="breadcrumb-item">Resume & Chart</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <h1 class="mb-4">Resume Magnetic Plugs (Approved Only)</h1> --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Model</th>
                                    <th>Unit Code</th>
                                    <th>HM</th>
                                    <th>ED
                                        <a href="{{ route('magnetic_plucks.index', array_merge(request()->all(), ['sort_ed' => 'asc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-down"></i>
                                        </a>
                                        <a href="{{ route('magnetic_plucks.index', array_merge(request()->all(), ['sort_ed' => 'desc'])) }}" class="btn btn-link p-0">
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
                                    @role(['admin', 'supervisor'])
                                        <th>Actions</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedData as $plug)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
                                        <td>{{ $plug->unit_model }}</td>
                                        <td>{{ $plug->unit_code }}</td>
                                        <td>{{ $plug->hm }}</td>
                                        <td>
                                            {{ $plug->last_update ? \Carbon\Carbon::parse($plug->last_update)->diffInDays(now()) : 'N/A' }} days
                                        </td>
                                        <td>{{ $plug->last_update }}</td>
                                        <td>{{ $plug->component }}</td>
                                        <td>{{ $plug->rating }}</td>
                                        <td>
                                            @if ($plug->picture)
                                            <a href="#" data-toggle="modal" data-target="#pictureModal{{ $plug->id }}">
                                                <img src="{{ asset('storage/' . $plug->picture) }}" alt="Picture" width="50" style="cursor: pointer;">
                                            </a>
                                            @else
                                            <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>{{ $plug->user->name ?? 'Unknown' }}</td>
                                        @role(['admin', 'supervisor'])
                                        <td>
                                            <a href="{{ route('magnetic_plucks.edit', $plug->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        @endrole
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

@foreach ($approvedData as $plug)
    @include('modals.picture_modal', ['image' => $plug->picture, 'modalId' => 'pictureModal' . $plug->id])
@endforeach

@include('modals.filter_component')

@push('scripts')
    {{-- Include Chart Script --}}
    @foreach ($charts as $chart)
        {!! $chart->script() !!}
    @endforeach
@endpush
@endsection
