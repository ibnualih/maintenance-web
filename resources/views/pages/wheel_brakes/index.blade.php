@extends('layouts.app')

@section('title', 'Wheel Brake')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Wheel Brake</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Maintenance</div>
                    <div class="breadcrumb-item active">Wheel Brake</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <a href="{{ route('wheel-brakes.create') }}" class="btn btn-primary">Add New</a>

                                <a href="{{ route('wheel-brakes.resume') }}" class="btn btn-info">View Resume</a>

                                <form method="GET" action="{{ route('wheel-brakes.index') }}" class="form-inline">
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
                                            @forelse ($wheelBrakes as $wheelBrake)
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
                                                    <td>
                                                        <span
                                                            class="px-2 py-1 text-sm font-medium rounded text-white"
                                                            style="background-color: {{ $wheelBrake->status === 'approved' ? '#28a745' : ($wheelBrake->status === 'pending' ? '#ffc107' : '#6c757d') }};">
                                                            {{ ucfirst($wheelBrake->status) }}
                                                        </span>
                                                    </td>
                                                    @role(['admin', 'supervisor'])
                                                    <td>{{ $wheelBrake->user->name ?? 'Tidak diketahui' }}</td>
                                                    <td>
                                                        @if($wheelBrake->status === 'pending')
                                                        @role('admin')
                                                            <form action="{{ route('wheel-brakes.approve', $wheelBrake->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                            </form>
                                                            <form action="{{ route('wheel-brakes.reject', $wheelBrake->id) }}" method="POST" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak dan menghapus data ini?');">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn-delete btn-danger btn-sm">Reject</button>
                                                            </form>
                                                        @endrole
                                                        @elseif($wheelBrake->status === 'approved')
                                                            <a href="{{ route('wheel-brakes.edit', $wheelBrake->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                            @role('admin')
                                                            <form action="{{ route('wheel-brakes.destroy', $wheelBrake->id) }}" method="POST" style="display:inline;">
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
                                                    <td colspan="17" class="text-center">No Data Found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $wheelBrakes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@foreach ($wheelBrakes as $wheelBrake)
    @include('modals.picture_modal', ['image' => $wheelBrake->picture, 'modalId' => 'pictureModal' . $wheelBrake->id])
@endforeach

@endsection

@push('scripts')
<script>
    handleDelete('.btn-delete'); // Memanggil fungsi global untuk tombol dengan class .btn-delete
</script>
@endpush
