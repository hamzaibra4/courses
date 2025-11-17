@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Assign Permissions</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Permissions</li>
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
                                <h4 class="card-title">Assign Permissions</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <form id="assignForm" action="{{ route('users.assign_permissions') }}" method="POST">
                                                @csrf
                                            <div class="row">

                                                <!-- Left Side: Select User -->
                                                <div class="col-md-5">
                                                    <div class="card p-1 shadow-sm">
                                                            <div class="form-group mb-3">
                                                                <label for="user_id">Select User</label>
                                                                <select id="user_id" name="user_id" class="form-control select2" required>
                                                                    <option value="">-- Select User --</option>
                                                                    @foreach($users as $user)
                                                                        <option value="{{ $user->id }}">  {{$user->name}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </div>
                                                </div>

                                                <!-- Right Side: Permissions -->
                                                <div class="col-md-7">
                                                    <div class="card p-1 shadow-sm">
                                                        <h5 class="mb-3">Assign Permissions</h5>

                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                                                            <label for="selectAllPermissions" class="form-check-label">Select All Permissions</label>
                                                        </div>

                                                        <input type="text" class="form-control mb-1" id="search-permissions" placeholder="Search permissions...">

                                                        <div class="permissionblock">
                                                            <div id="permissions-container">
                                                            @foreach($permissions as $permission)
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input permission-checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                                                    <label for="perm_{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        </div>


                                                    </div>

                                                </div>

                                            </div>
                                                <button type="submit" class="btn btn-primary mt-3 full-width">Assign Permissions</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('customjs')
    <script src="{{asset('cms/custom/permissions.js')}}" type="text/javascript"></script>
@endsection
