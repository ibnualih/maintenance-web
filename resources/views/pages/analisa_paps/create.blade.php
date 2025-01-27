@extends('layouts.app')

@section('title', 'Add Data')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Dashboard</a></div>
                    <div class="breadcrumb-item">Analisa PAPs</a></div>
                    <div class="breadcrumb-item">Add Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('analisa_pap.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Add Data</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Group Location</label>
                                <input type="text" class="form-control @error('grouploc') is-invalid @enderror" name="grouploc">
                                @error('grouploc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Add Code</label>
                                <input type="text" class="form-control @error('ADD_CODE') is-invalid @enderror" name="ADD_CODE">
                                @error('ADD_CODE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Branch</label>
                                <input type="text" class="form-control @error('branch') is-invalid @enderror" name="branch">
                                @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Lab Number</label>
                                <input type="text" class="form-control @error('Lab_No') is-invalid @enderror" name="Lab_No">
                                @error('Lab_No')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Sample Date</label>
                                <input type="date" class="form-control @error('SAMPL_DT1') is-invalid @enderror" name="SAMPL_DT1">
                                @error('SAMPL_DT1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Unit ID</label>
                                <input type="text" class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                                @error('unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Customer ID</label>
                                <input type="text" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Component ID</label>
                                <input type="text" class="form-control @error('ComponentID') is-invalid @enderror" name="ComponentID">
                                @error('ComponentID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Model</label>
                                <input type="text" class="form-control @error('MODEL') is-invalid @enderror" name="MODEL">
                                @error('MODEL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Oil Type</label>
                                <input type="text" class="form-control @error('OIL_TYPE') is-invalid @enderror" name="OIL_TYPE">
                                @error('OIL_TYPE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Hours KM Total</label>
                                <input type="text" class="form-control @error('HRS_KM_TOT') is-invalid @enderror" name="HRS_KM_TOT">
                                @error('HRS_KM_TOT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Oil Change</label>
                                <input type="text" class="form-control @error('oil_change') is-invalid @enderror" name="oil_change">
                                @error('oil_change')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Viscosity 40</label>
                                <input type="text" class="form-control @error('visc_40') is-invalid @enderror" name="visc_40">
                                @error('visc_40')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>TBN 40</label>
                                <input type="text" class="form-control @error('TBN_40') is-invalid @enderror" name="TBN_40">
                                @error('TBN_40')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>TBN Code</label>
                                <input type="text" class="form-control @error('TBN_CODE') is-invalid @enderror" name="TBN_CODE">
                                @error('TBN_CODE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Calcium</label>
                                <input type="text" class="form-control @error('CALCIUM') is-invalid @enderror" name="CALCIUM">
                                @error('CALCIUM')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Zinc Code</label>
                                <input type="text" class="form-control @error('ZINC_CODE') is-invalid @enderror" name="ZINC_CODE">
                                @error('ZINC_CODE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Water</label>
                                <input type="text" class="form-control @error('WATER') is-invalid @enderror" name="WATER">
                                @error('WATER')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Sodium</label>
                                <input type="text" class="form-control @error('SODIUM') is-invalid @enderror" name="SODIUM">
                                @error('SODIUM')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Silicon</label>
                                <input type="text" class="form-control @error('SILICON') is-invalid @enderror" name="SILICON">
                                @error('SILICON')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Iron</label>
                                <input type="text" class="form-control @error('IRON') is-invalid @enderror" name="IRON">
                                @error('IRON')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>FE Code</label>
                                <input type="text" class="form-control @error('FE_CODE') is-invalid @enderror" name="FE_CODE">
                                @error('FE_CODE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Lead</label>
                                <input type="text" class="form-control @error('LEAD') is-invalid @enderror" name="LEAD">
                                @error('LEAD')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Recommendation 1</label>
                                <input type="text" class="form-control @error('RECOMM1') is-invalid @enderror" name="RECOMM1">
                                @error('RECOMM1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control @error('Notes') is-invalid @enderror" name="Notes"></textarea>
                                @error('Notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
@endpush
