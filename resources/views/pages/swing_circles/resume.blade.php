@extends('layouts.app')

@section('title', 'Swing Circle Resume & Chart')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Swing Circle Resume & Chart</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('swing_circles.index') }}">Swing Circle</a></div>
                <div class="breadcrumb-item">Resume & Chart</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <h1 class="mb-4">Resume Swing Circles (Approved Only)</h1> --}}
                        <table class="table table-striped text-center align-middle custom-table">
                            <thead class="custom-header">
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">Unit Model</th>
                                    <th rowspan="3">Unit Code</th>
                                    <th rowspan="3">HM</th>
                                    <th rowspan="3">ED
                                        <a href="{{ route('swing_circles.index', array_merge(request()->all(), ['sort_ed' => 'asc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-down"></i>
                                        </a>
                                        <a href="{{ route('swing_circles.index', array_merge(request()->all(), ['sort_ed' => 'desc'])) }}" class="btn btn-link p-0">
                                            <i class="fas fa-sort-amount-up"></i>
                                        </a>
                                    </th>
                                    <th rowspan="3">Peak Value</th>
                                    <th colspan="5">Last Date</th>
                                    <th rowspan="3">Submitted By</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Front</th>
                                    <th colspan="2">Rear</th>
                                    <th colspan="1">Level Grease</th>
                                </tr>
                                <tr>
                                    <th colspan="1">Value</th>
                                    <th colspan="1">Picture</th>
                                    <th colspan="1">Value</th>
                                    <th colspan="1">Picture</th>
                                    <th colspan="1">Picture</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedData as $swingCircle)
                                    <tr>
                                        <td>{{ $startNumber + $loop->iteration }}</td>
                                        <td>{{ $swingCircle->unit_model }}</td>
                                        <td>{{ $swingCircle->unit_code }}</td>
                                        <td>{{ $swingCircle->hm }}</td>
                                        <td>{{ $swingCircle->ed }} days</td>
                                        <td>{{ $swingCircle->peak_value }}</td>
                                        <td>{{ $swingCircle->front_value }}</td>
                                        <td>
                                            @if ($swingCircle->front_picture)
                                            <a href="#" data-toggle="modal" data-target="#frontPicture{{ $swingCircle->id }}">
                                                <img src="{{ asset('storage/' . $swingCircle->front_picture) }}" alt="Front Picture" width="50" style="cursor: pointer;">
                                            </a>
                                            @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>{{ $swingCircle->rear_value }}</td>
                                        <td>
                                            @if ($swingCircle->rear_picture)
                                            <a href="#" data-toggle="modal" data-target="#rearPicture{{ $swingCircle->id }}">
                                                <img src="{{ asset('storage/' . $swingCircle->rear_picture) }}" alt="Rear Picture" width="50" style="cursor: pointer;">
                                            </a>
                                            @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($swingCircle->level_grease_picture)
                                            <a href="#" data-toggle="modal" data-target="#levelPicture{{ $swingCircle->id }}">
                                                <img src="{{ asset('storage/' . $swingCircle->level_grease_picture) }}" alt="Grease Picture" width="50" style="cursor: pointer;">
                                            </a>
                                            @else
                                                <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>{{ $swingCircle->user->name ?? 'Unknown' }}</td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="14" class="text-center">No data available.</td>
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

@foreach ($approvedData as $swingCircle)
    {{-- Modal untuk Front Picture --}}
    @if ($swingCircle->front_picture)
        @include('modals.picture_modal', ['image' => $swingCircle->front_picture, 'modalId' => 'frontPicture' . $swingCircle->id])
    @endif

    {{-- Modal untuk Rear Picture --}}
    @if ($swingCircle->rear_picture)
        @include('modals.picture_modal', ['image' => $swingCircle->rear_picture, 'modalId' => 'rearPicture' . $swingCircle->id])
    @endif

    {{-- Modal untuk Level Grease Picture --}}
    @if ($swingCircle->level_grease_picture)
        @include('modals.picture_modal', ['image' => $swingCircle->level_grease_picture, 'modalId' => 'levelPicture' . $swingCircle->id])
    @endif
@endforeach


{{-- @include('modals.filter_unit_model') --}}
@include('modals.filter_status')

@push('scripts')
    {{-- Include Chart Script
    @foreach ($charts as $chart)
        {!! $chart->script() !!}
    @endforeach --}}
@endpush
@endsection
