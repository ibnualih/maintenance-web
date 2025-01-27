@extends('layouts.app')

@section('title', 'Swing Circles')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Swing Circles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Swing Circles</div>
                    <div class="breadcrumb-item">Index</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('swing_circles.create') }}" class="btn btn-primary">Add Swing Circle</a>

                        <a href="{{ route('swing_circles.resume')}}" class="btn btn-info">View Resume</a>

                        <form method="GET" action="{{ route('swing_circles.index') }}" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by Unit Model or Code Unit" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                        <th rowspan="3">Status
                                            @role(['admin', 'supervisor'])
                                                <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#filterStatusModal">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            @endrole
                                        </th>
                                        @role(['admin', 'supervisor'])
                                            <th rowspan="3">User</th>
                                            <th rowspan="3">Actions</th>
                                        @endrole
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
                                    @forelse ($swingCircles as $swingCircle)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
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
                                            <td>
                                                <span
                                                    class="px-2 py-1 text-sm font-medium rounded text-white"
                                                    style="background-color: {{ $swingCircle->status === 'approved' ? '#28a745' : ($swingCircle->status === 'pending' ? '#ffc107' : '#6c757d') }};">
                                                    {{ ucfirst($swingCircle->status) }}
                                                </span>
                                            </td>
                                        @role(['admin', 'supervisor'])
                                        <td>{{ $swingCircle->user->name ?? 'Tidak diketahui' }}</td>
                                        <td>
                                            @if($swingCircle->status === 'pending')
                                            @role('admin')
                                                <form action="{{ route('swing_circles.approve', $swingCircle->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('swing_circles.reject', $swingCircle->id) }}" method="POST" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak dan menghapus data ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn-delete btn-danger btn-sm">Reject</button>
                                                </form>
                                            @endrole
                                            @elseif($swingCircle->status === 'approved')
                                                <a href="{{ route('swing_circles.edit', $swingCircle->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @role('admin')
                                                <form action="{{ route('swing_circles.destroy', $swingCircle->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete btn-danger btn-sm">Delete</button>
                                                </form>
                                                @endrole
                                            @endif
                                        </td>
                                        @endrole
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="14" class="text-center">No data available.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $swingCircles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@foreach ($swingCircles as $swingCircle)
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


@include('modals.filter_unit_model')
@include('modals.filter_status')

@push('scripts')
<script>
    handleDelete('.btn-delete'); // Memanggil fungsi global untuk tombol dengan class .btn-delete
</script>
@endpush
