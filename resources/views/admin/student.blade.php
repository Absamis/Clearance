@extends("layouts.adminlayout")
@section("content")
<div class="container-fluid mt-3">
    <div class="d-flex">
        <button class="text-dark text-center no-btn d-block" onclick="history.back()">
            <i class="fas fa-arrow-left fa-lg"></i>
        </button>
        <a href="/admin/students/nd2" class="text-dark text-center w-25 no-btn d-block ad-tab @if($level== "nd2") active @endif">
            ND2
        </a>
        <a href="/admin/students/hnd2" class="text-dark text-center w-25 d-block no-btn ad-tab @if($level== "hnd2") active @endif">
            HND2
        </a>
    </div>
    @if($show == "session")
    <div class="mt-3">
        <div class="card col-md-6 mx-auto p-2">
            @foreach ($details as $key => $value)
                <a href="/admin/students/{{ $level }}?sess={{ $value["session_date"] }}" class="text-left btn bg-brown mt-2">
                    <i class="fas fa-calendar"></i> {{ $value["session_date"] }} Academic session
                </a>
            @endforeach
        </div>
    </div>
    @endif

    @if($show == "department")
    {{-- Departments --}}
    <div class="mt-3">
        <div class="card col-md-6 mx-auto p-2">
            @foreach ($details as $key => $value)
                <a href="/admin/students/{{ $level }}?sess={{ $sess }}&dept={{ $key }}" class="text-left btn bg-brown mt-2">
                    <i class="fas fa-chalkboard-teacher"></i> {{ $value }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    @if($show == "student")
    {{-- Departments --}}
    <div class="mt-3">
        <div class="card col-md-6 mx-auto p-2">
            @foreach ($details as $key => $value)
                <a href="/admin/student/{{ $value["studentid"] }}?level={{ $level }}&sess={{ $sess }}" class="text-left btn bg-brown mt-2">
                    <i class="fas fa-graduation-cap"></i> {{ $value["name"] }}
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
