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
        <div class="mt-4">
            <div class="col-md-5 mx-auto">
                <div class="card p-0 m-3">
                    @if(session('failed'))
                        <div class="alert alert-danger mb-0">
                            <i class="fas fa-times-circle mr-2"></i> {{session('failed')}}
                        </div>
                    @endif
                    <div class="card-nav d-flex">
                        <button type="button" class="w-100 no-btn @if($title =="signup") active @endif tab-btn" data-assoc-tab="signup-wrapper">
                            Signup
                        </button>
                        <button type="button" class="w-100 no-btn @if($title =="signin") active @endif tab-btn" data-assoc-tab="signin-wrapper">
                            Signin
                        </button>
                    </div>
                    <div class="signup-wrapper" @if($title =="signin") style="display: none;" @endif>
                        <div class="card-body p-sm-2 p-1">
                            <div class="form-wrapper mt-2">
                                <form action="/signup" method="post">
                                    @csrf
                                    <div class="form-group p-1">
                                        <div class="form-input-group">
                                            <span class="input-append">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" name="fullname" class="form-input" value="{{ old('fullname') }}" placeholder="Fullame">

                                        </div>
                                        @error('fullname')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="row m-0">
                                        <div class="form-group col-md-7 p-1">
                                            <div class="form-input-group">
                                                <span class="input-append">
                                                    <i class="fas fa-university"></i>
                                                </span>
                                                 <select class="form-input" name="department">
                                                    <option value="">Select Department...</option>
                                                    @foreach ($department as $key => $value)
                                                        <option value="{{ $key }}" @if (old('department') == $key)
                                                            selected
                                                        @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            @error('department')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-5 p-1">
                                            <div class="form-input-group">
                                                <span class="input-append">
                                                    <i class="fas fa-chalkboard-teacher"></i>
                                                </span>
                                                <select class="form-input" name="level">
                                                    <option value="">Select Level...</option>
                                                    <option value="nd2" @if (old('level') == "nd2")
                                                        selected
                                                    @endif>ND2</option>
                                                    <option value="hnd2" @if (old('level') == "hnd2")
                                                        selected
                                                    @endif>HND2</option>
                                                </select>

                                            </div>
                                            @error('level')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="form-group col-md-5 p-1">
                                            <div class="form-input-group">
                                                <span class="input-append">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </span>
                                                <input type="text" class="form-input" name="matric" value="{{ old('matric') }}" placeholder="Matric number">

                                            </div>
                                            @error('matric')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="form-group col-md-7 p-1">
                                            <div class="form-input-group">
                                                <span class="input-append">
                                                    <i class="fas fa-phone-alt"></i>
                                                </span>
                                                <input type="text" class="form-input" value="{{ old('phone') }}" name="phone" placeholder="Phone number">

                                            </div>
                                             @error('phone')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="form-group p-1">
                                        <div class="form-input-group">
                                            <span class="input-append">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" autocomplete="false" value="{{ old('email') }}" class="form-input" name="email" placeholder="Email">

                                        </div>
                                         @error('email')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="row m-0">
                                        <div class="form-group col-md-12 p-1">

                                            <div class="form-input-group">
                                                <span class="input-append">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" value="{{ old('password') }}" name="password" class="form-input" placeholder="Password">
                                            </div>
                                            @error('password')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                                <small>At least 8 characters with combination of letter and number</small>
                                        </div>
                                        {{-- <div class="form-group col-md-6 p-1">
                                            <div class="form-input-group">
                                                <span class="input-append">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" name="cpassword" class="form-input" placeholder="Confirm password">

                                            </div>
                                            @error('cpassword')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                        </div> --}}
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="abs-btn text-white round bg-purple">
                                            <i class="fas fa-paper-plane"></i>
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Sign in section --}}
                    <div class="signin-wrapper" @if($title =="signup") style="display: none;" @endif>
                        <div class="card-body p-sm-2 p-1">
                            <div class="form-wrapper mt-2">
                                <form action="/signin" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-input-group">
                                            <span class="input-append">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" name="email" class="form-input" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-input-group">
                                            <span class="input-append">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" name="password" class="form-input" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="abs-btn round text-white bg-purple">
                                            <i class="fas fa-user-circle"></i>
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
