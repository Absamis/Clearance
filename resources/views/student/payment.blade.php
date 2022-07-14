@extends("layouts.studentlayout")
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            @if (!session('pay-confirm'))
                <div class="col-md-6 mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="font-weight-bold">
                                <i class="fas fa-credit-card"></i>
                                Make Payment
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="/payment/confirm" method="post">
                                @csrf
                                <div class="form-group">
                                    {{-- <label class="form-label">Title</label> --}}
                                    <input type="hidden" name="stid" value="{{ session('user') }}" />
                                    <div class="form-input-group">
                                        <span class="input-append mr-0">
                                            <i class="fas fa-credit-card"></i>
                                        </span>
                                        <select name="type" class="form-input ml-0">
                                            <option value="">Select payment type..</option>
                                            @foreach ($payment as $key => $value)
                                                <option value="{{ $value['catid'] }}">{{ $value['cat_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('type')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="abs-btn round btn-purple">
                                        Next <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('pay-confirm'))
                @php $data = session('data') @endphp
                <div class="d-flex align-content-center card col-md-5 mx-auto shadow">
                    <div class="card-body p-0 pb-2">
                        {{-- <h5 class="font-weight-bold m-0 p-2 fa-1x">Fill the details appropriately</h5> --}}
                        <p class="alert alert-danger err d-none">
                            <button type="button" class="btn" data-dismiss='alert'>&times</button>
                        </p>
                        <p class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            please check out the details correctly before proceeding
                        </p>
                        <div class="m-3 border-1 border-danger ">
                            <h6 class="text-center p-2">User Details</h6>
                            <ul class="list-unstyled bg-light">
                                <li class="data d-none">{{ $data['studentid'] }}</li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Payment Type</b></span>
                                    <span class="data">{{ old('type') }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Amount</b></span>
                                    <span class="data amt">{{ old('amount') }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Session</b></span>
                                    <span class="">{{ $data['session'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Name</b></span>
                                    <span class="data">{{ $data['name'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Matric</b></span>
                                    <span class="data">{{ $data['matric'] }}</span>
                                </li>

                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Level</b></span>
                                    <span class="data">{{ $data['level'] }}</span>
                                </li>
                                <li class="d-flex justify-content-between p-2">
                                    <span class=""><b>Email</b></span>
                                    <span class="data" id="email">{{ $data['email'] }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/payments" id='cancel' class="abs-btn round text-white bg-danger">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                            <button type="submit" id="pay" class="abs-btn pay-btn round text-white bg-success"
                                onclick="payWithPaystack()">
                                <i class="fas fa-credit-card"></i>
                                Proceed to payment
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2">
                            <i class="fas fa-history"></i>
                            Transactions
                        </h5>
                        <ul class="list-unstyled list-group">
                            @if ($paidfee)
                                @foreach ($paidfee as $key => $value)
                                    <li class="list-group-item mt-2 notification-tab">
                                        <span class="">
                                            <i class="fas fa-file fa-1x card-text mr-2"></i>
                                            <span class="fa-1x">{{ $value['trans_type'] }}</span>
                                            <span class="badge badge-pills badge-success"><i
                                                    class="fas fa-check-circle"></i> Paid</span>
                                        </span>
                                        <div class="">
                                            <a href="/payments/details/{{ $value['transID'] }}"
                                                class="badge btn-warning p-1">
                                                details <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        var stddata = {};
        var initvals = {};
        document.querySelectorAll('.data').forEach((arg, index) => {
            stddata[index] = arg.textContent;
        })

        function payWithPaystack() {
            document.querySelector('.err').style.display = 'none';
            if (navigator.onLine) {
                var handler = PaystackPop.setup({
                    key: 'pk_test_99139a1d024c2b41386ed4cd6b89cebe8e59b73a', // Replace with your public key
                    email: document.getElementById('email').textContent,
                    amount: document.querySelector(".amt").textContent *
                        100, // the amount value is multiplied by 100 to convert to the lowest currency unit
                    currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
                    ref: '', // Replace with a reference you generated
                    callback: function(response) {
                        //this happens after the payment is completed successfully
                        var reference = response.reference;
                        // document.querySelector('#pay').disable = true;
                        document.querySelector('.preloader').style.display = 'flex';
                        var formdata = new FormData();
                        formdata.append('details', JSON.stringify(stddata))
                        formdata.append('ref', reference);
                        formdata.append('_token', '{{ csrf_token() }}')
                        new makeHttpRequest({
                            url: '/payment',
                            method: 'post',
                            data: formdata
                        }).done((response) => {
                            try {
                                var report = JSON.parse(response);
                                // console.log(report['data']);
                                if (report['data']['status'] == 'success') {
                                    // alert('successful with ref = '  + report.data.reference)
                                    console.log(report);
                                    document.querySelector('.preloader').style.display = 'none';
                                    location.href = '/payments';
                                } else {
                                    document.querySelector('#pay').disable = false;
                                    document.querySelector('#cancel').disable = false;
                                    document.querySelector('.err').style.display = 'block';
                                    document.querySelector('.err').textContent =
                                        'Transaction Failed, Try again Later';
                                    document.querySelector('.preloader').style.display = 'none';
                                }
                            } catch (err) {
                                console.log(err);
                                document.querySelector('.preloader').style.display = 'none';
                                document.querySelector('.err').style.display = 'block';
                                document.querySelector('.err').textContent =
                                    'Error occured, Try again later';
                            }
                        }).send();
                        // location.href="/payment/verify";
                        // Make an AJAX call to your server with the reference to verify the transaction
                    },
                    onClose: function() {
                        alert('Transaction was not completed. Try again later.');
                    },
                });
                handler.openIframe();
            } else {
                document.querySelector('.err').style.display = 'block';
                document.querySelector('.err').textContent = 'No internet Connection';
            }
        }
    </script>
@endsection
