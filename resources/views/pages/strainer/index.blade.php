@extends('layouts.app')

@section('title', 'Strainers')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Strainers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item">Strainer List</div>
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
                        <a href="{{ route('strainer.create') }}" class="btn btn-primary">Add Strainer</a>

                        <a href="{{ route('strainer.resume') }}" class="btn btn-info">View Resume & Chart</a>

                        <form method="GET" action="{{ route('strainer.index') }}" class="form-inline">
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
                                        <th>ED
                                            <a href="{{ route('strainer.index', array_merge(request()->all(), ['sort_ed' => 'asc'])) }}" class="btn btn-link p-0">
                                                <i class="fas fa-sort-amount-down"></i>
                                            </a>
                                            <a href="{{ route('strainer.index', array_merge(request()->all(), ['sort_ed' => 'desc'])) }}" class="btn btn-link p-0">
                                                <i class="fas fa-sort-amount-up"></i>
                                            </a>
                                        </th>
                                        <th>Last Update</th>
                                        <th>Component</th>
                                        <th>Rating
                                            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#filterModal">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                        </th>
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
                                    @forelse ($strainers as $strainer)
                                        <tr>
                                            <td>{{ $startNumber + $loop->iteration }}</td>
                                            <td>{{ $strainer->unit_model }}</td>
                                            <td>{{ $strainer->unit_code }}</td>
                                            <td>{{ $strainer->hm }}</td>
                                            <td>
                                                {{ $strainer->last_update ? \Carbon\Carbon::parse($strainer->last_update)->diffInDays(now()) : 'N/A' }} days
                                            </td>
                                            <td>{{ $strainer->last_update }}</td>
                                            <td>{{ $strainer->component }}</td>
                                            <td>{{ $strainer->rating }}</td>
                                            <td>
                                                @if ($strainer->picture)
                                                    <a href="#" data-toggle="modal" data-target="#pictureModal{{ $strainer->id }}">
                                                        <img src="{{ asset('storage/' . $strainer->picture) }}" alt="Picture" width="50" style="cursor: pointer;">
                                                    </a>
                                                @else
                                                    <span>No Picture</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="px-2 py-1 text-sm font-medium rounded text-white"
                                                    style="background-color: {{ $strainer->status === 'approved' ? '#28a745' : ($strainer->status === 'pending' ? '#ffc107' : '#6c757d') }};">
                                                    {{ ucfirst($strainer->status) }}
                                                </span>
                                            </td>
                                            @role(['admin', 'supervisor'])
                                            <td>{{ $strainer->user->name ?? 'Tidak diketahui' }}</td>
                                            <td>
                                                @if($strainer->status === 'pending')
                                                @role('admin')
                                                    <form action="{{ route('strainer.approve', $strainer->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                    </form>
                                                    <form action="{{ route('strainer.reject', $strainer->id) }}" method="POST" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak dan menghapus data ini?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn-delete btn-danger btn-sm">Reject</button>
                                                    </form>
                                                @endrole
                                                @elseif($strainer->status === 'approved')
                                                    <a href="{{ route('strainer.edit', $strainer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    @role('admin')
                                                    <form action="{{ route('strainer.destroy', $strainer->id) }}" method="POST" style="display:inline;">
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
                                            <td colspan="12" class="text-center">No Strainers found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $strainers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@foreach ($strainers as $strainer)
    @include('modals.picture_modal', ['image' => $strainer->picture, 'modalId' => 'pictureModal' . $strainer->id])
@endforeach

@include('modals.filter_rating')
@include('modals.filter_status')

@endsection
@push('scripts')
<script>
    handleDelete('.btn-delete'); // Memanggil fungsi global untuk tombol dengan class .btn-delete
</script>
@endpush
