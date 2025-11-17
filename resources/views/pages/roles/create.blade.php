@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Roles</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route("roles.index")}}">Home</a></li>
                            <li class="breadcrumb-item active">Roles</li>
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
                                <h4 class="card-title">Roles</h4>
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
                                            <form action="{{ route('roles.store') }}" method="POST">
                                                @csrf
                                                <!-- Role Name -->
                                                <div class="form-group mb-1">
                                                    <label for="roleName">Role Name</label>
                                                    <input type="text" name="name" class="form-control" id="roleName" placeholder="Enter role name" required>
                                                </div>


                                                <div class="form-group mb-1">
                                                    <label>Assign Permissions</label>

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

                                                <div class="form-actions">
                                                    @can('List_Role')
                                                        <a href="{{ route('roles.index') }}" class="btn btn-warning button-cancel">   <i class="ft-x"></i>&nbsp;Cancel</a>
                                                    @endcan
                                                    @can('Add_Role')
                                                        <button type="submit" class="btn btn-primary  ml-1"> <i class="la la-check-square-o"></i>Save</button>
                                                    @endcan
                                                </div>


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
    <script src="{{asset('cms/custom/roles.js')}}" type="text/javascript"></script>
@endsection
