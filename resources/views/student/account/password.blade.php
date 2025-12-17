@extends('layouts.front')


@section('content')


    <div class="page-section pb-0">
        <div class="container page__container d-flex flex-column flex-sm-row align-items-sm-center">
            <div class="flex">
                <h1 class="h2 mb-0">Change Password</h1>
                <p class="text-breadcrumb">Account Management</p>
            </div>
            <p class="d-sm-none"></p>
        </div>
    </div>

    <div class="page-section ">
        <div class="container page__container mycard">

            <form action="{{ route('user.password.update') }}" method="POST" class="col-sm-12 p-0">
                @csrf

                <div class="form-row">

                    <div class="form-group col-12">
                        <label class="form-label">Old Password</label>
                        <input type="password"
                               name="current_password"
                               class="form-control"
                               placeholder="Enter old password"
                               required>
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label">New Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter new password"
                               required>
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Confirm new password"
                               required>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save Password</button>
            </form>

            @if(session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>



@endsection
