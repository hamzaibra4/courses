@extends('layouts.app')
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Watched videos</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        @can('List_Watched_Video')
                            <li class="breadcrumb-item"><a href="{{ route('watched-video.index') }}">Home</a></li>
                        @endcan
                        <li class="breadcrumb-item active">Watched videos</li>
                    </ol>
                </div>
            </div>
        </div>

        @can('Add_Watched_Video')
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right">
                    <a class="btn btn-info box-shadow-2 px-2" href="{{ route('watched-video.create') }}">
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
                            <h4 class="card-title">Watched videos</h4>
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
                                        <th>Student</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($watchedvideo as $obj)
                                        <tr id="row{{ $obj->id }}">

                                            <td>{{ $obj->student->f_name }} {{ $obj->student->l_name }}</td>
                                            <td>
                                                @can('Edit_Watched_Video')
                                                    <a href="{{ route('watched-video.edit', $obj->id) }}" class="icons warning">
                                                        <i class="fa-solid fa-pen-to-square"
                                                           data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                                    </a>
                                                @endcan

                                                @can('Delete_Watched_Video')
                                                    <a href="#"
                                                       data-id="{{ $obj->id }}"
                                                       data-url="{{ route('watched-video.destroy', $obj->id) }}"
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
                                        <th>Student</th>
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
