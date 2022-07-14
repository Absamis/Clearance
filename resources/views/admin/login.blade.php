<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="{{ asset("assets/css/all.css") }}">
    <link type="text/css" rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">
    <link type="text/css" rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
    <title>Admin.....Login</title>
    <style>

    </style>
</head>
<body>
    <div class="main">
        <div class="container">
            <div class="card mt-3 col-sm-6 mx-auto">
                <div class="card-body">
                    <h4 class="">Admin Login</h4>
                    <div class="">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form class="" action="/admin/login" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="id">Login ID</label>
                                <input type="text" name='loginid' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="id">Password</label>
                                <input type="password" name='passkey' class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset("assets/js/jquery-3.5.1.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/popper.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("assets/js/custom-script.js") }}"></script>
</body>
</html>
