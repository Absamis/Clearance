@extends("layouts.studentlayout")
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-6 mt-2 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2">
                            <i class="fas fa-spinner"></i>
                            Clearance progress
                        </h5>
                        <ul class="list-unstyled list-group">
                            <li class="list-group-item mt-2 d-flex align-items-center">
                                <span class="">
                                    <i
                                        class="fas  @if ($paypr == 'complete') fa-check-circle text-success @else fa-circle text-gray @endif fa-lg"></i>
                                    <span class="ml-2 content-text font-weight-bold">Payment of fees</span>
                                </span>
                                <span class="badge badge-success mb-0 ml-auto">
                                    @if ($paypr == 'complete')
                                        approved
                                    @else
                                        {{ $paypr[1] . ' of ' . $paypr[0] }}
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item mt-2 d-flex align-items-center">
                                <span class="">
                                    <i
                                        class="fas @if ($docpr == 'complete') fa-check-circle text-success @else fa-circle text-gray @endif fa-lg"></i>
                                    <span class="ml-2 content-text font-weight-bold">Verification of documents</span>
                                </span>
                                <span class="badge badge-success mb-0 ml-auto">
                                    @if ($docpr == 'complete')
                                        approved
                                    @else
                                        {{ $docpr[1] . ' of ' . $docpr[0] }}
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item mt-2">
                                <i class="fas fa-circle text-gray fa-lg"></i>
                                <span class="ml-2 content-text font-weight-bold">Validation of clearance</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
