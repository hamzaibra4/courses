@extends('layouts.app')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Chapter </h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('chapter.index')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Chapter</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        @can('Add_Chapter')
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a class="btn btn-info  box-shadow-2 px-2"
                       href="{{route('chapter.create')}}"
                       role="button"><i class="fa-solid fa-plus"></i>Chapter</a>
                    <div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <div class="content-body">
        <section id="file-export">
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <section id="file-export">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card itemcard">
                                            <div class="card-header">
                                                <h4 class="card-title">Chapter</h4>
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
                                                    <table class="table table-striped table-bordered file-export2">
                                                        <thead>
                                                        <tr>
                                                            <th>Chapter Name</th>
                                                            <th>Course Name</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach(($chapter ?? []) as $obj)
                                                            <tr id="row{{$obj->id}}">

                                                                <td>{{ $obj->name}}</td>
                                                                <td>{{ $obj->getCourse->name}}</td>

                                                                <td>
                                                                    @can('Edit_Chapter')
                                                                        <a href="{{ route('chapter.edit', $obj->id) }}" class="icons warning"> <i class="fa-solid fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                                                        </a>
                                                                    @endcan
                                                                            @can('Delete_Chapter')
                                                                                <a href="#" data-id="{{ $obj->id }}" data-url="{{ route('chapter.destroy', $obj) }}" class="deleteRow icons danger"><i class="fa-solid fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                                                                </a>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th>Chapter Name</th>
                                                            <th>Course Name</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <input type='hidden' id='message' value='@if(session()->has('message')){{ session()->get('message') }}@endif' />
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
