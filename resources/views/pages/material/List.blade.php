@extends('layouts.app')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Materials</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        @can('List_Material')
                            <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Home</a></li>
                        @endcan
                        <li class="breadcrumb-item active">Materials</li>
                    </ol>
                </div>
            </div>
        </div>

        @can('Add_Material')
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right">
                    <a class="btn btn-info box-shadow-2 px-2" href="{{ route('material.create') }}">
                        <i class="fa-solid fa-plus"></i> Create
                    </a>
                </div>
            </div>
        @endcan
    </div>

    <div class="content-body">
        <section id="file-export">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h4 class="card-title">Materials</h4>
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

                                <table class="table table-striped table-bordered file-export2">
                                    <thead>
                                    <tr>
                                        <th>Link</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($material as $obj)
                                        <tr id="row{{ $obj->id }}">

                                            <td>{{ $obj->path }}</td>

                                            <td>
                                                @can('Edit_Material')
                                                    <a href="{{ route('material.edit', $obj->id) }}" class="icons warning">
                                                        <i class="fa-solid fa-pen-to-square"
                                                           data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                                    </a>
                                                @endcan

                                                @can('Delete_Material')
                                                    <a href="#"
                                                       data-id="{{ $obj->id }}"
                                                       data-url="{{ route('material.destroy', $obj->id) }}"
                                                       class="deleteRow icons danger">
                                                        <i class="fa-solid fa-trash"
                                                           data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                                    </a>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>Link</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>

                                <input type="hidden" id="message"
                                       value="@if(session()->has('message')){{ session()->get('message') }}@endif">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
