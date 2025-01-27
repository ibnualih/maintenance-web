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
                            <div class="card-header">
                                <a href="{{ route('wheel-brakes.create') }}" class="btn btn-primary float-right">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center align-middle custom-table">
                                        <thead class="custom-header">
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Unit Code</th>
                                                <th rowspan="2">SN</th>
                                                <th rowspan="2">HM</th>
                                                <th colspan="3">Engine</th>
                                                <th colspan="3">Transmission</th>
                                                <th colspan="3">Differential</th>
                                                <th colspan="3">Circle Gear</th>
                                                <th colspan="3">Tandem LH</th>
                                                <th colspan="3">Tandem RH</th>
                                                <th colspan="3">Hydraulic</th>
                                                <th rowspan="2">Action</th>
                                            </tr>
                                            <tr>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                                <th>Last Sampling</th>
                                                <th>Condition</th>
                                                <th>Oil Change</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($wheelBrakes as $wheelBrake)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $wheelBrake->unit_code }}</td>
                                                    <td>{{ $wheelBrake->hm }}</td>
                                                    <td>{{ $wheelBrake->ed }}</td>
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
                                                        <a href="{{ route('wheel-brakes.edit', $wheelBrake->id) }}" class="btn btn-info btn-sm">Edit</a>
                                                        <form action="{{ route('wheel-brakes.destroy', $wheelBrake->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="15" class="text-center">No Data Found</td>
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
