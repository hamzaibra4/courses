
@extends('layouts.front')


@section('content')

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Account</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                        <li class="breadcrumb-item">

                            <a href="#">Account</a>

                        </li>

                        <li class="breadcrumb-item active">

                            Edit Account

                        </li>

                    </ol>

                </div>
            </div>

        </div>
    </div>


    <div class="container page__container page-section">
        <div class="page-separator">
            <div class="page-separator__text">Basic Information</div>
        </div>

        <form class="col-md-12 p-0">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">First name</label>
                    <input type="text"
                           class="form-control"
                           value="Alexander"
                           placeholder="Your first name ...">
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Last name</label>
                    <input type="text"
                           class="form-control"
                           value="Watson"
                           placeholder="Your last name ...">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email address</label>
                <input type="email"
                       class="form-control"
                       value="alexander.watson@fake-mail.com"
                       placeholder="Your email address ...">
                <small class="form-text text-muted">
                    Note that if you change your email, you will have to confirm it again.
                </small>
            </div>

            <button class="btn btn-primary">Save changes</button>

        </form>
    </div>


@endsection
