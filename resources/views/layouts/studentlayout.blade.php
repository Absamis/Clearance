<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Final clearance</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/all.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/bootstrap.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css") }}">
    </head>
    <body>
        <div class="preloader">
            <div class="">
                <i class="fas fa-spinner fa-spin fa-4x text-primary"></i>
            </div>
        </div>
        @include('include.navbar')
        <div class="main p-2">
            <nav class="topbar mt-3">
                <div class="p-2">
                    <h5 class="font-weight-bold m-0 p-2">
                        <i class="far fa-user-circle"></i>
                        Welcome back, {{ session("username") }}
                    </h5>
                    <h5 class="text-right font-weight-bold m-0 p-2">
                        <i class="far fa-calendar"></i>
                       {{ session('session') }} Academic Session
                    </h5>
                </div>
                <div class="d-flex ml-3 mt-3 align-items-center justify-content-between">
                    <h4 class="font-weight-bold">{{$title }}</h4>
                    <div class="acts mr-3">
                        <span class="m-1">
                            <i class="fas fa-bell fa-lg"></i>
                        </span>
                        <span class="m-1">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </span>
                    </div>
                </div>
            </nav>
            @yield("content")
        </div>
        <script type="text/javascript" src="{{ asset("assets/js/jquery-3.5.1.js") }}"></script>
        <script type="text/javascript" src="{{ asset("assets/js/popper.min.js") }}"></script>
        <script type="text/javascript" src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
        <script type="text/javascript" src="{{ asset("assets/js/custom-script.js") }}"></script>
        <script type="text/javascript" src="{{ asset("assets/js/helper-script.js") }}"></script>
        <script>
            let tabObj = {};
            document.querySelectorAll(".tab-btn").forEach(function(arg,index){
                tabObj[index] = arg.dataset.assocTab;
                arg.onclick= function(e){
                    switchTab(index, tabObj);
                }
            })
        </script>
    </body>
</html>
