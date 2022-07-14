@extends("layouts.adminlayout")
@section("content")
<div class="container-fluid mt-3">
    <div class="d-flex">
        <a href="/admin/settings/nd2" class="text-dark text-center w-25 no-btn d-block ad-tab @if($level== "nd2") active @endif">
            ND2
        </a>
        <a href="/admin/settings/hnd2" class="text-dark text-center w-25 d-block no-btn ad-tab @if($level== "hnd2") active @endif">
            HND2
        </a>
    </div>
    {{-- Departments --}}
    <div class="mt-3 container">
        <div class="card bg-lightbrown col-md-9 mx-auto">
            <div class="card-body">
                 @if(session('error'))
                <div class="alert alert-danger">{{ session("error") }}</div>
                @elseif(session('success'))
                <div class="alert alert-success">{{ session("success") }}</div>
                @endif
                {{-- Payment settings section --}}
                <div class="row justify-content-center">
                    <div class="col-sm-6 p-3 pxys">
                        <h5 class="font-weight-bold mb-2">Add Payment Type</h5>
                        <form action="/admin/settings/add" method="post">
                            @csrf
                            <input type="hidden" name="level" value="{{ $level }}" />
                            <input type="hidden" name="cat" value="payment" />
                            <div class="form-group">
                                <input type="text" name="ptype" value="{{ old('ptype') }}" class="form-control" placeholder="Payment type">
                                @error('ptype')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" min="100" value="{{ old('amount') }}" name="amount" class="form-control" placeholder="Amount">
                                @error('amount')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-light text-warning">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </form>
                    </div>
                    @if(!empty($payment))
                    <div class="col-sm-6 p-3">
                        <ul class="list-group">
                            @foreach ($payment as $key => $value)
                            <li class="list-group-item profile-list p-2 mt-2">
                                <p class="prop text-capitalize">{{ $value["cat_name"]}}</p>
                                <p class="">{{ $value["cat_price"]}}</p>
                                <p class="">
                                    <a href="">
                                        <i class="fas fa-edit text-info"></i>
                                    </a>
                                    <a href="">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <hr/>
                {{-- Document settings section --}}
                <div class="row justify-content-center">
                    <div class="col-sm-6 p-3 pxys">
                        <h5 class="font-weight-bold mb-2">Add Document</h5>
                        <form action="/admin/settings/add" method="post">
                            @csrf
                            <input type="hidden" name="level" value="{{ $level }}" />
                            <input type="hidden" name="cat" value="document" />
                            <div class="form-group">
                                <input type="text" value="{{ old("dtype") }}" name="dtype" class="form-control" placeholder="Document">
                                @error('dtype')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-light text-warning">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </form>
                    </div>
                    @if(!empty($document))
                    <div class="col-sm-6 p-3">
                        <ul class="list-group">
                            @foreach ($document as $key => $value)
                            <li class="list-group-item profile-list p-2 mt-2">
                                <p class="prop">{{ $value["cat_name"] }}</p>
                                <p class="">
                                    <a href="">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector(".notice-btn").onclick = function(){
        if(document.querySelector(".notify-form").style.display == "block")
            document.querySelector(".notify-form").style.display = "none";
        else
            document.querySelector(".notify-form").style.display = "block";
    }
</script>

@endsection
