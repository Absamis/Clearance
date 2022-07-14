@extends("layouts.adminlayout")
@section('content')
    <div class="container-fluid mt-3">
        <div class="mt-3 card col-md-5 mx-auto">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @elseif (session('success'))
                    <div class="alert alert-success">{{ session('error') }}</div>
                @endif

                <form class="" action="/admin/changepassword" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Old password</label>
                        <input type="password" class="form-control" placeholder="old password" name="oldpass">
                        @error('oldpass')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">New password</label>
                        <input type="password" class="form-control" placeholder="new passwod" name="newpass">
                        @error('newpass')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Confirm password</label>
                        <input type="password" class="form-control" placeholder="confirm password" name="cpass">
                        @error('cpass')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" value="" class="btn btn-warning">
                            Change
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
