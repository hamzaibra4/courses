@extends('layouts.app')
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{$route->screen_name}}</h3>
            </div>

            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

                    @can("Add_".$route->model_name)
                        @if($route->has_add)
                            <a class="btn btn-info  box-shadow-2 px-2"
                               href="{{route($route->route.'.create')}}"
                               role="button"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;&nbsp;Create </a>
                        @endif
                    @endcan

                    <div></div>
                </div>
            </div>

        </div>
        <div class="content-body">

            <!-- File export table -->
            <section id="file-export">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$route->screen_name}}</h4>
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
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered file-export">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $obj)
                                                <tr id='row{{$obj->id}}'>
                                                    <td>{{$obj->name}}</td>
                                                    <td>
                                                        @can("Edit_".$route->model_name)
                                                            <a href="{{route($route->route.'.edit',['id'=>$obj->id])}}" class="icons warning"><i class="fa-solid fa-pen-to-square"></i> </a>
                                                        @endif

                                                        @can("Delete_".$route->model_name)
                                                            @if($route->has_delete)
                                                                @if(is_null($obj->key) || ($obj->key =='') )
                                                                    <a href="#" data-id='{{$obj->id}}' data-url='{{route($route->route.'.delete',['id'=>$obj->id])}}' class="deleteRow icons danger"><i class="fa-solid fa-trash"></i></a>
                                                                @endif
                                                            @endif
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- File export table -->
        </div>
    </div>

@endsection
