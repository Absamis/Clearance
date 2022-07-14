@extends("layouts.adminlayout")
@section("content")
<div class="container-fluid">
    <div class="card col-md-4 p-0 shadow">
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">{{ session("error") }}</div>
            @elseif(session('success'))
            <div class="alert alert-success">{{ session("success") }}</div>
            @endif
            <h5 class="">Set Session</h5>
            <form class="mt-2" action="/admin/session" method="post">
                @csrf
                <div class="form-group">
                    <select name="session" class="form-control">
                        <option value="">Select session..</option>
                        <option value="{{ (date("Y") - 1) ."/". date("Y") }}">{{ (date("Y") - 1) ."/". date("Y") }}</option>
                        <option value="{{ date("Y") ."/". (date("Y") + 1) }}">
                            {{ date("Y") ."/". (date("Y") + 1) }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-warning">
                        <i class="fas fa-pencil-square-o"></i> Change
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
    </div>
</div>
@endsection
