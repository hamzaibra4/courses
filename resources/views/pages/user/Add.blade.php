@extends('layouts.app')
@section('content')
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Users</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Users')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('user.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $users ? 'Edit User' : 'Add User' }}
                            </li>
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
                                <h4 class="card-title">Users</h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>

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

                                    <form action="{{ $users ? route('user.update', $users->id) : route('user.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($users)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Name<span>*</span></label>
                                                        <input id="name" required type="text" class="form-control"
                                                               name="name" placeholder="Enter Name"
                                                               value="{{ old('name', $users->name ?? '') }}">

                                                        @error('name')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Email<span>*</span></label>
                                                        <input id="email" required type="text" class="form-control"
                                                               name="email" placeholder="Enter your Email"
                                                               value="{{ old('email', $users->email?? '') }}">

                                                        @error('email')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                            </div>
                                                @if($users==null)
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">Password<span>*</span></label>
                                                        <input id="password" required type="password" class="form-control"
                                                               name="password" placeholder="Enter your Password"
                                                               value="{{ old('password') }}">

                                                        @error('password')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="form-group cust-form-input col-12">
                                                    <label for="user_type_id">User Type<span class="is-required">*</span></label>

                                                    @php
                                                        $current = old('user_type_id', $users->user_type_id ?? null);
                                                    @endphp

                                                    <select class="form-control my-2 select2" name="user_type_id" id="user_type_id" required>
                                                        <option value="" {{ $current ? '' : 'selected' }}>Select User Type</option>

                                                        @foreach($types as $id => $name)
                                                            <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('user_type_id')
                                                    <div class="error-msg">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                            </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_Users')
                                                        <a href="{{ route('user.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan
                                                        @canany(['Add_Users', 'Edit_Users'])
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcanany


                                                </div>
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
