@extends("layouts.studentlayout")
@section('content')
    <div class="container-fluid">
        <div class="payment-form">
            <div class="d-flex card col-md-5 mx-auto shadow">
                <div class="card-body">
                    <div class="m-3 border-1 border-danger">
                        <h6 class="text-center p-2">Transaction Details</h6>

                        @if (isset($details))
                            <ul class="list-unstyled bg-light">
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Matric</b></span>
                                    <span class="">{{ $details['matric'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Transaction ID</b></span>
                                    <span class="">{{ $details['transID'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Pay Type</b></span>
                                    <span class="">{{ $details['trans_type'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Session</b></span>
                                    <span class="">{{ $details['session'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Date</b></span>
                                    <span class="">{{ explode(' ', $details['created_at'])[0] }}</span>
                                </li>
                            </ul>
                            <button type="submit" class="abs-btn round d-block mt-2 text-white bg-success">
                                <i class="fas fa-download"></i>
                                Download receipt
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
