@extends('layouts.app')

@section('title', 'Analisa PAP')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Analisa PAP</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Tracks</div>
                    <div class="breadcrumb-item">Analisa PAP</div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="section-header-button">
                                    <a href="{{ route('analisa_pap.create') }}" class="btn btn-primary">Add Data</a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>grouploc</th>
                                                <th>ADD_CODE</th>
                                                <th>Branch</th>
                                                <th>Lab No</th>
                                                <th>SAMPL_DT1</th>
                                                <th>Unit ID</th>
                                                <th>Customer ID</th>
                                                <th>Name</th>
                                                <th>Component ID</th>
                                                <th>MODEL</th>
                                                <th>OIL_TYPE</th>
                                                <th>HRS_KM_TOT</th>
                                                <th>oil_change</th>
                                                <th>visc_40</th>
                                                <th>TBN_40</th>
                                                <th>TBN_CODE</th>
                                                <th>CALCIUM</th>
                                                <th>ZINC_CODE</th>
                                                <th>WATER</th>
                                                <th>SODIUM</th>
                                                <th>SILICON</th>
                                                <th>IRON</th>
                                                <th>FE_CODE</th>
                                                <th>LEAD</th>
                                                <th>RECOMM1</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($analisa_paps as $index => $analisa_pap)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $analisa_pap->grouploc }}</td>
                                                    <td>{{ $analisa_pap->ADD_CODE }}</td>
                                                    <td>{{ $analisa_pap->branch }}</td>
                                                    <td>{{ $analisa_pap->Lab_No }}</td>
                                                    <td>{{ $analisa_pap->SAMPL_DT1 }}</td>
                                                    <td>{{ $analisa_pap->unit_id }}</td>
                                                    <td>{{ $analisa_pap->customer_id }}</td>
                                                    <td>{{ $analisa_pap->name }}</td>
                                                    <td>{{ $analisa_pap->ComponentID }}</td>
                                                    <td>{{ $analisa_pap->MODEL }}</td>
                                                    <td>{{ $analisa_pap->OIL_TYPE }}</td>
                                                    <td>{{ $analisa_pap->HRS_KM_TOT }}</td>
                                                    <td>{{ $analisa_pap->oil_change }}</td>
                                                    <td>{{ $analisa_pap->visc_40 }}</td>
                                                    <td>{{ $analisa_pap->TBN_40 }}</td>
                                                    <td>{{ $analisa_pap->TBN_CODE }}</td>
                                                    <td>{{ $analisa_pap->CALCIUM }}</td>
                                                    <td>{{ $analisa_pap->ZINC_CODE }}</td>
                                                    <td>{{ $analisa_pap->WATER }}</td>
                                                    <td>{{ $analisa_pap->SODIUM }}</td>
                                                    <td>{{ $analisa_pap->SILICON }}</td>
                                                    <td>{{ $analisa_pap->IRON }}</td>
                                                    <td>{{ $analisa_pap->FE_CODE }}</td>
                                                    <td>{{ $analisa_pap->LEAD }}</td>
                                                    <td>{{ $analisa_pap->RECOMM1 }}</td>
                                                    <td>{{ $analisa_pap->Notes }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href='{{ route('analisa_pap.edit', $analisa_pap->id) }}' class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('analisa_pap.destroy', $analisa_pap->id) }}" method="POST" class="ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
@endsection
