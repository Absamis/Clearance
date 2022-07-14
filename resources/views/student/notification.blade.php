@extends("layouts.studentlayout")
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2">
                            <i class="fas fa-bell"></i>
                            Recent Notifications
                        </h5>
                        <div class="list-unstyled list-group">
                            @foreach ($data as $key => $value)
                                <a href="/notifications/{{ $value->msgid }}"
                                    class="list-group-item mt-2 notification-tab colored">
                                    <span class="">
                                        <i class="fas fa-users fa-1x card-text mr-2"></i>
                                        <span class="fa-1x">Message from Admin</span>
                                    </span>
                                    <small class="">
                                        <i class="fas fa-history"></i>
                                        {{ explode(' ', $value->created_at)[0] }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @if ($read)
                <div class="col-md-6 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="">
                                <b>From Admin</b><br />
                                <small>
                                    <i class="fas fa-history"></i> {{ explode(' ', $read->created_at)[0] }}
                                </small>
                            </p>
                            <p class="content-text">
                                {{ $read->message }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
