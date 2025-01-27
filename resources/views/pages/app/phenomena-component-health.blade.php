@extends('layouts.app')

@section('title', 'Phenomena Component Health')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header text-center">
                <h1>PHENOMENA COMPONENT HEALTH</h1>
            </div>
            <div class="row justify-content-center">
                <!-- TRACK Section -->
                <div class="col-md-6">
                    <h5 class="text-center">TRACK</h5>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Component</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ENGINE</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'engine']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>PTO</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'pto']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>FINAL DRIVE LH</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'final_drive_lh']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>FINAL DRIVE RH</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'final_drive_rh']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>HYDRAULIC</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'hydraulic']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>CIRCLE BEARING</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'circle_bearing']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>SWING FRONT</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'swing_front']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>SWING REAR</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'swing_rear']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>DAMPER</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.track', ['component' => 'damper']) }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- WHEEL Section -->
                <div class="col-md-6">
                    <h5 class="text-center">WHEEL</h5>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Component</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ENGINE</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.wheel', 'engine') }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>TRANSMISSION</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.wheel', 'transmission') }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>FINAL DRIVE LH</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.wheel', 'final_drive_lh') }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>FINAL DRIVE RH</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.wheel', 'final_drive_rh') }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>DIFFERENTIAL</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.wheel', 'differential') }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>HYDRAULIC</td>
                                <td>
                                    <span class="text-warning">CAUTION: "TOTAL PHENOMENA"</span><br>
                                    <span class="text-danger">CRITICAL: "TOTAL PHENOMENA"</span>
                                </td>
                                <td>
                                    <a href="{{ route('phenomena.wheel', 'hydraulic') }}" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
