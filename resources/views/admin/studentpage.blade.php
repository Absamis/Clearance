@extends("layouts.adminlayout")
@section('content')
    <div class="container-fluid mt-3">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @elseif (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex">
            <a href="/admin/students/nd2"
                class="text-dark text-center w-25 no-btn d-block ad-tab @if ($level == 'nd2') active @endif">
                ND2
            </a>
            <a href="/admin/students/hnd2"
                class="text-dark text-center w-25 d-block no-btn ad-tab @if ($level == 'hnd2') active @endif">
                HND2
            </a>
        </div>

        {{-- Departments --}}
        <div class="mt-3 container">
            <div class="card bg-lightbrown">
                <div class="card-body">
                    <div class="row">
                        @if ($studentdetails)
                            <div class="col-sm-4 p-3 pxys">
                                <div class="profile text-center">
                                    <i class="fas fa-user-circle fa-4x"></i>
                                    <h5 class="font-weight-bold">{{ $studentdetails['name'] }}
                                        <small class="badge badge-pills badge-success"><i
                                                class="fas fa-user-check"></i></small>
                                    </h5>
                                </div>
                                <div class="body mt-3">
                                    <ul class="list-unstyled">
                                        <li class="profile-list">
                                            <p class="prop">Email</p>
                                            <p class="val text-lowercase">{{ $studentdetails['email'] }}</p>
                                        </li>
                                        <li class="profile-list">
                                            <p class="prop">Matric number</p>
                                            <p class="val text-capitalize">{{ $studentdetails['matric'] }}</p>
                                        </li>
                                        <li class="profile-list">
                                            <p class="prop">Phone number</p>
                                            <p class="val text-capitalize">{{ $studentdetails['phone'] }}</p>
                                        </li>
                                        <li class="profile-list">
                                            <p class="prop">Department</p>
                                            <p class="val text-capitalize">{{ $studentdetails['department'] }}</p>
                                        </li>
                                        <li class="profile-list">
                                            <p class="prop">Level</p>
                                            <p class="val text-uppercase">{{ $studentdetails['level'] }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="top p-2 text-right">
                                    <button type="button" title="comment" class="bg-lightbrown no-btn notice-btn">
                                        <i class="fas fa-comment fa-lg text-info font-weight-bold"></i>
                                    </button>
                                    <a href="/admin/students/{{ $level }}?sess={{ $session }}"
                                        onclick="return confirm('Are you sure to leave this page', 'Leave', 'Cancel')"
                                        title="close" class="bg-lightbrown no-btn notice-btn">
                                        <i class="fas fa-times fa-lg text-danger font-weight-bold"></i>
                                    </a>
                                    <div class="notify-form" style="display: none">
                                        <form action="/admin/notification" method="post">
                                            @csrf
                                            <input type="hidden" value="{{ $studentdetails['studentid'] }}"
                                                name="userid" />
                                            <input type="hidden" name="session"
                                                value="{{ $studentdetails['session'] }}" />
                                            <div class="form-group">
                                                <textarea class="form-control" name="message" rows="3"
                                                    cols="5"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-outline-light text-dark">
                                                <i class="fas fa-paper-plane"></i> Send
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="body">
                                    <ul class="list-unstyled mt-2">
                                        <li class="">
                                            <h5 class="label">
                                                <i class="fas fa-circle"></i> Payments
                                            </h5>

                                            <ul class="list-unstyled m-2 row mt-2">
                                                @if ($paystatus)
                                                    @foreach ($paystatus as $key => $value)
                                                        <li class="col-md-4 mt-2">
                                                            <div class="card pxys ">
                                                                <div class="card-body text-center">
                                                                    <p class="m-0"><i
                                                                            class="fas @if ($value['status'] == 1) fa-check-circle text-success @else fa-times-circle text-danger @endif fa-2x"></i>
                                                                    </p>
                                                                    <p class="m-0 font-weight-bold"
                                                                        style="font-size: 18px;">{{ $key }}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>

                                        {{-- Documents upload --}}
                                        <li class="mt-4">
                                            <h5 class="label">
                                                <i class="fas fa-circle"></i> Documents uploaded
                                            </h5>

                                            <ul class="list-unstyled m-2 row mt-2">
                                                @if ($docstatus)
                                                    @foreach ($docstatus as $key => $value)
                                                        <li class="col-md-6 mt-2">
                                                            <div class="card pxys">
                                                                <p class="m-0 p-2 d-flex align-items-center">
                                                                    @if ($value['status'] == 0)
                                                                        <span class="badge badge-pills badge-warning">
                                                                            Pending
                                                                        </span>
                                                                    @elseif ($value['status'] == 1)
                                                                        <span class="badge badge-pills badge-success">
                                                                            Approved
                                                                        </span>
                                                                    @elseif ($value['status'] == -1)
                                                                        <span class="badge badge-pills badge-danger">
                                                                            Declined
                                                                        </span>
                                                                    @endif

                                                                    @if ($value['status'] == 0)
                                                                        <div class="ml-auto">
                                                                            <form class="d-inline"
                                                                                action="/admin/documents/verify/{{ $value['docid'] }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <button type="submit" class="border-0"
                                                                                    title="approve">
                                                                                    <i
                                                                                        class="fas fa-check-circle fa-lg text-success"></i>
                                                                                </button>
                                                                            </form>
                                                                            <form class="d-inline"
                                                                                action="/admin/documents/decline/{{ $value['docid'] }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <button type="submit" class="border-0"
                                                                                    title="decline">
                                                                                    <i
                                                                                        class="fas fa-times-circle fa-lg text-danger"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                </p>
                                                                <div class="card-body text-center p-2 docs">
                                                                    <a href="{{ Storage::url($value['docname']) }}"
                                                                        target="_blank" class="text-dark m-0 image">
                                                                        <i class="far fa-image fa-2x"></i> click to peview
                                                                    </a>
                                                                    <p class="m-0 font-weight-bold"
                                                                        style="font-size: 18px;">{{ $value['doc_type'] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if ($docpend)
                                                    @foreach ($docpend as $key)
                                                        <li class="col-md-6 mt-2">
                                                            <div class="card pxys">
                                                                <div class="m-0 p-3 d-flex align-items-center">
                                                                    <i class="fas text-danger fa-times-circle fa-lg"></i>
                                                                    <p class="m-0 font-weight-bold ml-2"
                                                                        style="font-size: 18px;">{{ $key['cat_name'] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif

                                                {{-- <li class="col-md-6 mt-2">
                                            <div class="card pxys">
                                                <p class="m-0 p-2 d-flex">
                                                    <span class="badge badge-pills badge-warning">
                                                        Pending
                                                    </span>
                                                    <span class="ml-auto">
                                                        <a href="">
                                                            <i class="fas fa-check-circle fa-lg text-success"></i>
                                                        </a>
                                                        <a href="">
                                                            <i class="fas fa-times-circle fa-lg text-danger"></i>
                                                        </a>
                                                    </span>
                                                </p>
                                                <div class="card-body text-center p-2 docs">
                                                    <p class="m-0 image">
                                                        <i class="far fa-image fa-2x"></i> click to peview
                                                    </p>
                                                    <p class="m-0 font-weight-bold" style="font-size: 18px;">School Fee Receipt</p>
                                                </div>
                                            </div>
                                        </li> --}}
                                            </ul>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else<h5 class="font-weight-bold ml-4">No record found</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector(".notice-btn").onclick = function() {
            if (document.querySelector(".notify-form").style.display == "block")
                document.querySelector(".notify-form").style.display = "none";
            else
                document.querySelector(".notify-form").style.display = "block";
        }
    </script>

@endsection
