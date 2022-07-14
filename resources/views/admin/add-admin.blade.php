@extends("layouts.adminlayout")
@section('content')
    <div class="container-fluid mt-3">
        <div class="mt-3 card col-md-5 mx-auto">
            <div class="card-body">
                <form class="" action="" method="">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Your Password</label>
                        <input type="password" class="form-control" placeholder="your passwod" name="new">
                    </div>
                    <div class="form-group">
                        <button type="submit" value="" class="btn btn-warning">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
