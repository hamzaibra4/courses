@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">All Roles</h4>
                    </div>
                    @can('Add_Role')
                        <a class="btn btn-info  box-shadow-2 px-2 float-right"
                           href="{{ route('roles.create') }}"
                           role="button"><i class="ri-user-add-fill"></i><i class="fa-solid fa-plus"></i> Create </a>
                    @endcan

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr id="row{{$role->id}}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('Edit_Role')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="icons warning"><i class="fa-solid fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                        @endcan

                                        @if(is_null($role->key))
                                            @can('Delete_Role')
                                                    <a href="#" data-id='{{$role->id}}' data-url='{{route('roles.destroy',['role'=>$role->id])}}' class="deleteRow icons danger"><i class="fa-solid fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                            @endcan
                                            @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th title="#">#</th>
                                <th title="Name">Name</th>
                                <th title="Actions">Actions</th>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


