@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Course</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Company')
                                <li class="breadcrumb-item"><a href="{{route('company.index')}}">Home</a></li>
                            @endcan
                            <li class="breadcrumb-item active">{{ $company ? 'Edit company' : 'Add company' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="file-export">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Company</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form action="{{ $company ? route('company.update', $company->id) : route('company.store') }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @if($company) @method('PUT') @endif

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name<span>*</span></label>
                                                        <input id="name" type="text" required class="form-control" name="name" value="{{ $company->name ?? old('name') }}" placeholder="Enter Company Name">
                                                        @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email<span>*</span></label>
                                                        <input id="email" type="text" class="form-control" name="email" value="{{ $company->email ?? old('email') }}" placeholder="Enter your Email">
                                                        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="address">Address<span>*</span></label>
                                                        <input id="address" type="text" class="form-control" name="address" value="{{ $company->address ?? old('address') }}" placeholder="Enter your Address">
                                                        @error('address') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="telephone">Phone Number<span>*</span></label>
                                                        <input id="telephone" type="number" class="form-control" name="telephone" value="{{ $company->telephone ?? old('telephone') }}" placeholder="Enter your Phone Number">
                                                        @error('telephone') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="invoice_prefix">Invoice prefix</label>
                                                        <input id="invoice_prefix" type="number" class="form-control" name="invoice_prefix" value="{{ $company->invoice_prefix ?? old('invoice_prefix') }}" placeholder="Enter your Invoice Prefix">
                                                        @error('invoice_prefix') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="payment_prefix">Payment prefix</label>
                                                        <input id="payment_prefix" type="number" class="form-control" name="payment_prefix" value="{{ $company->payment_prefix ?? old('payment_prefix') }}" placeholder="Enter your Payment Prefix">
                                                        @error('payment_prefix') <div class="error-msg">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Logo<span>*</span></label>
                                                            <input type="file" name="logo" onchange="previewFile(this, 'previewImage')" id="projectinput1" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    @if($company?->logo)
                                                        <div class="form-group">
                                                            <div class="image-area remove-black margin1020">
                                                                <img  src="{{asset($company->logo)}}" data-enlargable id="previewImage" class="img" width="200px">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <div class="image-area remove-black margin1020">
                                                                <img src="{{ old('logo') }}" data-enlargable id="previewImage" class="img onadd" width="200px">
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Signature Image</label>
                                                            <input type="file"  name="signature_image" onchange="previewFile(this, 'previewImage1')" id="projectinput2" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    @if($company?->signature_image)
                                                        <div class="form-group">
                                                            <div class="image-area remove-black margin1020">
                                                                <img  src="{{asset($company->signature_image)}}" data-enlargable id="previewImage1" class="img" width="200px">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <div class="image-area remove-black margin1020">
                                                                <img src="{{ old('signature_image') }}" data-enlargable id="previewImage1" class="img onadd" width="200px">
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="form-actions mt-3">
                                                    <a href="{{ route('company.index') }}">
                                                        <button type="button" class="btn btn-warning">
                                                            <i class="ft-x"></i> Cancel
                                                        </button>
                                                    </a>

                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> Save
                                                    </button>
                                            </div>

                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection



