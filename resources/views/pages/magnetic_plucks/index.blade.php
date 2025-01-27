@extends('layouts.app')

@section('title', 'Magnetic Pluck')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Magnetic Plug</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Magnetic Plug</div>
                <div class="breadcrumb-item">List</div>
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
                    <a href="{{ route('magnetic_plucks.create') }}" class="btn btn-primary">New Magnetic Plug</a>

                    <a href="{{ route('magnetic_plucks.resume') }}" class="btn btn-info">View Resume & Chart</a>

                    <form method="GET" action="{{ route('magnetic_plucks.index') }}" class="form-inline">
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
                        <table class="table-striped table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Model</th>
                                    <th>Unit Code</th>
                                    <th>HM</th>
                                    <th>
                                        ED
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
                                    <th>Status
                                        @role(['admin', 'supervisor'])
                                            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#filterStatusModal">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                        @endrole
                                    </th>
                                    @role(['admin', 'supervisor'])
                                        <th>User</th>
                                        <th>Actions</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($magneticPlugs as $pluck)
                                    <tr>
                                        <td>{{ $startNumber + $loop->iteration }}</td>
                                        <td>{{ $pluck->unit_model }}</td>
                                        <td>{{ $pluck->unit_code }}</td>
                                        <td>{{ $pluck->hm }}</td>
                                        <td>
                                            {{ $pluck->last_update ? \Carbon\Carbon::parse($pluck->last_update)->diffInDays(now()) : 'N/A' }} days
                                        </td>
                                        <td>{{ $pluck->last_update }}</td>
                                        <td>{{ $pluck->component }}</td>
                                        <td>{{ $pluck->rating }}</td>
                                        <td>
                                            @if ($pluck->picture)
                                            <a href="#" data-toggle="modal" data-target="#pictureModal{{ $pluck->id }}">
                                                <img src="{{ asset('storage/' . $pluck->picture) }}" alt="Picture" width="50" style="cursor: pointer;">
                                            </a>
                                            @else
                                            <span>No Picture</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="px-2 py-1 text-sm font-medium rounded text-white"
                                                style="background-color: {{ $pluck->status === 'approved' ? '#28a745' : ($pluck->status === 'pending' ? '#ffc107' : '#6c757d') }};">
                                                {{ ucfirst($pluck->status) }}
                                            </span>
                                        </td>
                                        @role(['admin', 'supervisor'])
                                        <td>{{ $pluck->user->name ?? 'Tidak diketahui' }}</td>
                                        <td>
                                            @if($pluck->status === 'pending')
                                                <form action="{{ route('magnetic.approve', $pluck->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('magnetic.reject', $pluck->id) }}" method="POST" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak dan menghapus data ini?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn-delete btn-danger btn-sm">Reject</button>
                                                </form>
                                            @elseif($pluck->status === 'approved')
                                                <a href="{{ route('magnetic_plucks.edit', $pluck->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @role('admin')
                                                <form action="{{ route('magnetic_plucks.destroy', $pluck->id) }}" method="POST" style="display:inline;">
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
                                        <td colspan="12" class="text-center">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </table>
                        </div>
                    <div class="float-right">
                        {{ $magneticPlugs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Section -->
@foreach ($magneticPlugs as $pluck)
    @include('modals.picture_modal', ['image' => $pluck->picture, 'modalId' => 'pictureModal' . $pluck->id])
@endforeach

@include('modals.filter_component')
@include('modals.filter_status')

@push('scripts')
<script>
    handleDelete('.btn-delete'); // Memanggil fungsi global untuk tombol dengan class .btn-delete
</script>
@endpush
@endsection
