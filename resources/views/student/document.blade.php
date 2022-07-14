@extends("layouts.studentlayout")
@section("content")
<div class="container-fluid mt-3">
    <div class="row">
        @if(session('allowdoc'))
        <div class="col-md-6 mt-2">
            <div class="card">
                @if(session('error'))
                    <div class="alert alert-danger mb-0">
                        <i class="fas fa-times-circle mr-2"></i> {{session('error')}}
                    </div>
                @elseif(session('success'))
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-check-circle mr-2"></i> {{session('success')}}
                    </div>
                @endif
                @if(!session('editdoc'))
                <div class="card-header">
                    <h5 class="font-weight-bold">
                        <i class="fas fa-upload"></i>
                        Upload Document
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/documents/upload" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <div class="form-input-group">
                                <span class="input-append mr-0">
                                    <i class="fas fa-circle"></i>
                                </span>
                                <select name="doctype" class="form-input ml-0">
                                    <option value="">Select title..</option>
                                    @foreach ($document as $key => $value)
                                        <option value="{{ $value["cat_name"] }}">{{ $value["cat_name"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error("doctype")
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Upload document</label>
                            <div class="form-input-group">
                                <span class="input-append mr-0">
                                    <i class="fas fa-file"></i>
                                </span>
                                <input type="file" name="file" class="form-input">
                            </div>
                            <small class="text-fade">only PDF file is allowed. 2MB max</small>
                            @error("file")
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="col-md-6 abs-btn round btn-purple">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
                @else


                <div class="card-header">
                    <h5 class="font-weight-bold">
                        <i class="fas fa-edit"></i>
                        Edit Document
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/documents/edit" method="post" enctype="multipart/form-data">
                        @csrf
                        <h4 class="font-weight-bold p-3">{{ old('doctype') }}</h4>
                        <a href="{{ Storage::url(old('docname')) }}" target="_blank" class="col-md-6 mt-3 bg-light abs-btn btn-btn">
                            <i class="fas fa-file"></i> {{ old('docname')}}
                        </a>
                        <input type="hidden" name="docid" value="{{ old('docid')}}" />
                        <input type="hidden" name="prevfile" value="{{ old('docname') }}" />
                        <div class="form-group">
                            <label class="form-label">Change Document</label>
                            <div class="form-input-group">
                                <span class="input-append">
                                    <i class="fas fa-file"></i>
                                </span>
                                <input type="file" name="file" class="form-input">
                            </div>
                            <small class="text-fade">only PDF file is allowed. 2MB max</small>;
                            @error("file")
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="col-md-6 abs-btn round btn-purple">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-2">
                        <i class="fas fa-folder"></i>
                        Documents</h5>
                    <ul class="list-unstyled list-group">
                        @if($upload)
                        @foreach ($upload as $key => $value)
                        <li class="list-group-item mt-2 notification-tab">
                            <span class="">
                                <i class="fas fa-file fa-1x card-text mr-2"></i>
                                <span class="fa-1x">{{ $value["doc_type"] }}</span>
                                @php
                                    if($value["status"] == 0){
                                        $bg = 'badge-warning';
                                        $txt = "Pending";
                                    }else if($value["status"] == -1){
                                        $bg = 'badge-danger';
                                        $txt = "Declined";
                                    }else if($value["status"] == 1){
                                        $bg = 'badge-success';
                                        $txt = "Approved";
                                    }
                                @endphp
                                <span class="badge badge-pills {{ $bg }}">
                                    {{ $txt}}
                                </span>
                            </span>
                            @if($txt == "Pending" || $txt == "Declined")
                            <div class="">
                                <a href="/documents/edit/{{ $value["docid"] }}" title="change" class="no-btn p-1">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <form class="d-inline" action="/documents/delete/{{ $value["docid"] }}" method="post">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure to remove this?')" title="remove" class="no-btn p-1">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-5 mt-5 mx-auto">
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                Sorry!!! You have no access to this page at the moment because, you have pending fees to pay
                <div class="">
                    <a href="/payments" class="btn alert-danger">
                        <i class="fas fa-credit-card"></i> Pay now
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
