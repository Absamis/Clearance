<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Final clearance</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale = 1.0">

        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/all.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/bootstrap.min.css") }}">
        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css") }}">
    </head>
    <body>

        <header>
            <nav class="bg-purple p-2 d-flex">
                <h4 class="font-weight-bold text-white">MAPOLY</h4>
            </nav>
        </header>
        <div class="mai">
            <div class=" col-md-5 mt-5 mx-auto">
                <div class="card p-0 m-4">
                    @if(isset($success))
                    <div class="card-header alert-success p-2">
                        <i class="fas fa-check-circle"></i>
                       {{ $success["head"] }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $success["body"]}}</p>
                        <a href="/" class="btn btn-info">
                            Done
                        </a>
                    </div>
                    @elseif(isset($failed))
                    <div class="card-header alert-danger p-2">
                        <i class="fas fa-times-circle"></i>
                        {{ $failed["head"]}}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $failed["body"] }}</p>
                        <a href="/" class="btn btn-info">
                            Done
                        </a>
                    </div>
                    @else

                    @endif
                </div>
            </div>
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
