@extends("layouts.adminlayout")
@section('content')
    <div class="container-fluid mt-3">
        <div class="mt-3">
            <div class="card col-md-6 mx-auto p-2">
                <a href="/admin/settings/nd2" class="text-left btn bg-brown mt-2">
                    <i class="fas fa-cogs"></i> Payment and Document
                </a>

                <a href="/admin/settings/security" class="text-left btn bg-brown mt-2">
                    <i class="fas fa-cog"></i> Change Password
                </a>

                @if (session('adid') == 1)
                    <a href="/admin/settings/sub-admin" class="text-left btn bg-brown mt-2">
                        <i class="fas fa-cog"></i> Add Admin
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
