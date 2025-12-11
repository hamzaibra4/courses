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

    <div class="page-section">
        <div class="container page__container">
            <div class="page-separator">
                <div class="page-separator__text">Change Password</div>
            </div>

            <form action="https://luma.humatheme.com/Demos/App_Layout/login.html"
                  class="col-sm-12 p-0">

                <div class="form-row">
                    <div class="form-group col-12">
                        <label class="form-label" for="password">Password:</label>
                        <input id="password"
                               type="password"
                               class="form-control"
                               placeholder="Type a new password ...">
                    </div>

                    <div class="form-group col-12">
                        <label class="form-label" for="password2">Confirm Password:</label>
                        <input id="password2"
                               type="password"
                               class="form-control"
                               placeholder="Confirm your new password ...">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save password</button>

            </form>
        </div>
    </div>



@endsection
