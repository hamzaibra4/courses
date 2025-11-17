@extends('layouts.app')
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{$route->screen_name}}</h3>
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
                                    @php
                                        $locales = config('translatable.locales');
                                    @endphp
                                    @if(!isset($data))

                                        <div class="card-content collapse show">
                                            <div class="card-body">


                                                <form action="{{route($route->route.'.store')}}" method="POST" class="floating-labels " enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">Title @if($route->has_translation) English @endif</label>
                                                                    <input type="text"  class="form-control"  name="en[name]" value="{{old('en.name')}}" required
                                                                    >
                                                                    @error('en.name')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            @if($route->has_translation)
                                                                @if(in_array('ar', $locales))
                                                                    <div class="col-md-12 multiple-lang-ar">
                                                                        <div class="form-group">
                                                                            <label for="projectinput2">Title Arabic</label>
                                                                            <input type="text" id="projectinput2"  class="form-control"  name="ar[name]" value="{{old('ar.name')}}"
                                                                            >
                                                                            @error('ar.name')
                                                                            <div class='error-msg'>{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                @if(in_array('fr', $locales))
                                                                    <div class="col-md-12 multiple-lang-fr">
                                                                        <div class="form-group">
                                                                            <label for="projectinput3">Title French</label>
                                                                            <input type="text" id="projectinput3"  class="form-control"  name="fr[name]" value="{{old('fr.name')}}"
                                                                            >
                                                                            @error('fr.name')
                                                                            <div class='error-msg'>{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif

                                                            @if($route->has_additional_field1)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput7">{{$route->additional_field1_name}} @if($route->has_translation) English @endif</label>
                                                                        <input type="text" id="projectinput7"  class="form-control"  name="en[add1]" value="{{old('en.add1')}}" required
                                                                        >
                                                                        @error('en.add1')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @if($route->has_translation)
                                                                    @if(in_array('ar', $locales))
                                                                        <div class="col-md-12 multiple-lang-ar">
                                                                            <div class="form-group">
                                                                                <label for="projectinput8">{{$route->additional_field1_name}} Arabic</label>
                                                                                <input type="text" id="projectinput8"  class="form-control"  name="ar[add1]" value="{{old('ar.add1')}}"
                                                                                >
                                                                                @error('ar.add1')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    @if(in_array('fr', $locales))
                                                                        <div class="col-md-12 multiple-lang-fr">
                                                                            <div class="form-group">
                                                                                <label for="projectinput9">{{$route->additional_field1_name}} French</label>
                                                                                <input type="text" id="projectinput9"  class="form-control"  name="fr[add1]" value="{{old('fr.add1')}}"
                                                                                >
                                                                                @error('fr.add1')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif

                                                            @if($route->has_additional_field2)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput10">{{$route->additional_field2_name}} @if($route->has_translation) English @endif</label>
                                                                        <input type="text" id="projectinput10"  class="form-control"  name="en[add2]" value="{{old('en.add2')}}" required
                                                                        >
                                                                        @error('en.add2')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @if($route->has_translation)
                                                                    @if(in_array('ar', $locales))
                                                                        <div class="col-md-12 multiple-lang-ar">
                                                                            <div class="form-group">
                                                                                <label for="projectinput11">{{$route->additional_field2_name}} Arabic</label>
                                                                                <input type="text" id="projectinput11"  class="form-control"  name="ar[add2]" value="{{old('ar.add2')}}"
                                                                                >
                                                                                @error('ar.add2')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(in_array('fr', $locales))
                                                                        <div class="col-md-12 multiple-lang-fr">
                                                                            <div class="form-group">
                                                                                <label for="projectinput12">{{$route->additional_field2_name}}  French</label>
                                                                                <input type="text" id="projectinput12"  class="form-control"  name="fr[add2]" value="{{old('fr.add2')}}"
                                                                                >
                                                                                @error('fr.add2')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif


                                                            @if($route->has_description)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput6">Description @if($route->has_translation) English @endif </label>
                                                                        <textarea rows="5" type="text" id="projectinput6" class="form-control @if($route->complex_description) ckeditor @endif"
                                                                                  name="en[description]"> {{old('en.description')}}
                                                                        </textarea>
                                                                        @error('en.description')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @if($route->has_translation)
                                                                    @if(in_array('ar', $locales))
                                                                        <div class="col-md-12  multiple-lang-ar">
                                                                            <div class="form-group">
                                                                                <label for="projectinput6">Description Arabic </label>
                                                                                <textarea rows="5" type="text" id="projectinput6" class="form-control @if($route->complex_description) ckeditor @endif"
                                                                                          name="ar[description]"> {{old('ar.description')}}
                                                                        </textarea>
                                                                                @error('ar.description')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(in_array('fr', $locales))
                                                                        <div class="col-md-12  multiple-lang-fr">
                                                                            <div class="form-group">
                                                                                <label for="projectinput6">Description French </label>
                                                                                <textarea rows="5" type="text" id="projectinput6" class="form-control @if($route->complex_description) ckeditor @endif"
                                                                                          name="fr[description]">
                                                                            {{old('fr.description')}}
                                                                        </textarea>
                                                                                @error('fr.description')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif



                                                            @if($route->has_image)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput13">Image</label>
                                                                        <input type="file" id="projectinput13" class="form-control"
                                                                               name="img" required
                                                                               onchange="previewFile(this,'previewImg')">
                                                                    </div>
                                                                    <img id="previewImg" class="onadd"  width="150" height="150"/>
                                                                    @error('img')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                            @endif

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">Index</label>
                                                                    <input type="number"  class="form-control"  name="item_index" value="{{old('item_index')}}"
                                                                    >
                                                                    @error('item_index')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            @if($route->has_parent)
                                                                <div class="col-md-12 ">
                                                                    <div class="form-group">
                                                                        <label for="projectinput1">Choose {{$route->parent_model}}</label>
                                                                        {!! Form::select('parentId', $parentData, '', ['class' => 'form-control select2', 'placeholder'=>'select record', 'required'=>'true']) !!}
                                                                        @error('parentId')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>

                                                        <div class="form-actions">
                                                            @can("List_".$route->model_name)
                                                                <a href="{{route($route->route)}}">
                                                                    <button type="button" class="btn btn-warning mr-1 button-cancel">
                                                                        <i class="ft-x"></i>&nbsp;Cancel
                                                                    </button>
                                                                </a>
                                                            @endcan
                                                            @can("Add_".$route->model_name)
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="la la-check-square-o"></i>&nbsp;Save
                                                                </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    @else

                                        <div class="card-content collapse show">
                                            <div class="card-body">

                                                <form action="{{route($route->route.'.update',['id'=>$data->id])}}" method="POST" class="floating-labels " enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')

                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">Title @if($route->has_translation) English @endif</label>
                                                                    <input type="text"  class="form-control"  name="en[name]" value="@if($route->has_translation){{$data->translate('en')->name}}@else {{$data->name}} @endif"  required
                                                                    >
                                                                    @error('en.name')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            @if($route->has_translation)
                                                                @if(in_array('ar', $locales))
                                                                    <div class="col-md-12 multiple-lang-ar">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">Title Arabic</label>
                                                                            <input type="text"  class="form-control"  name="ar[name]" value="{{$data->translate('ar')->name}}"
                                                                            >
                                                                            @error('ar.name')
                                                                            <div class='error-msg'>{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                @if(in_array('fr', $locales))
                                                                    <div class="col-md-12 multiple-lang-ar">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">Title French</label>
                                                                            <input type="text"  class="form-control"  name="fr[name]" value="{{$data->translate('fr')->name}}"
                                                                            >
                                                                            @error('fr.name')
                                                                            <div class='error-msg'>{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            @endif




                                                            @if($route->has_additional_field1)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput7">{{$route->additional_field1_name}} @if($route->has_translation) English @endif</label>
                                                                        <input type="text" id="projectinput7"  class="form-control"  name="en[add1]" value="@if($route->has_translation){{$data->translate('en')->additional_field1}}@else {{$data->additional_field1}} @endif" required
                                                                        >
                                                                        @error('en.add1')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @if($route->has_translation)
                                                                    @if(in_array('ar', $locales))
                                                                        <div class="col-md-12 multiple-lang-ar">
                                                                            <div class="form-group">
                                                                                <label for="projectinput8">{{$route->additional_field1_name}} Arabic</label>
                                                                                <input type="text" id="projectinput8"  class="form-control"  name="ar[add1]" value="{{$data->translate('ar')->additional_field1}}"
                                                                                >
                                                                                @error('ar.add1')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(in_array('fr', $locales))
                                                                        <div class="col-md-12 multiple-lang-fr">
                                                                            <div class="form-group">
                                                                                <label for="projectinput9">{{$route->additional_field1_name}} French</label>
                                                                                <input type="text" id="projectinput9"  class="form-control"  name="fr[add1]" value="{{$data->translate('fr')->additional_field1}}"
                                                                                >
                                                                                @error('fr.add1')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif

                                                            @if($route->has_additional_field2)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput10">{{$route->additional_field2_name}} @if($route->has_translation) English @endif</label>
                                                                        <input type="text" id="projectinput10"  class="form-control"  name="en[add2]" value="@if($route->has_translation){{$data->translate('en')->additional_field2}}@else {{$data->additional_field2}} @endif" required
                                                                        >
                                                                        @error('en.add2')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @if($route->has_translation)
                                                                    @if(in_array('ar', $locales))
                                                                        <div class="col-md-12 multiple-lang-ar">
                                                                            <div class="form-group">
                                                                                <label for="projectinput11">{{$route->additional_field2_name}} Arabic</label>
                                                                                <input type="text" id="projectinput11"  class="form-control"  name="ar[add2]" value="{{$data->translate('ar')->additional_field2}}"
                                                                                >
                                                                                @error('ar.add2')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                    @endif
                                                                    @if(in_array('fr', $locales))
                                                                        <div class="col-md-12 multiple-lang-fr">
                                                                            <div class="form-group">
                                                                                <label for="projectinput12">{{$route->additional_field2_name}}  French</label>
                                                                                <input type="text" id="projectinput12"  class="form-control"  name="fr[add2]" value="{{$data->translate('fr')->additional_field2}}"
                                                                                >
                                                                                @error('fr.add2')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif


                                                            @if($route->has_description)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput6">Description @if($route->has_translation) English @endif </label>
                                                                        <textarea rows="5" type="text" id="projectinput6" class="form-control @if($route->complex_description) ckeditor @endif"
                                                                                  name="en[description]"> @if($route->has_translation){{$data->translate('en')->name}}@else {{$data->description}} @endif
                                                                        </textarea>
                                                                        @error('en.description')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @if($route->has_translation)
                                                                    @if(in_array('ar', $locales))
                                                                        <div class="col-md-12  multiple-lang-ar">
                                                                            <div class="form-group">
                                                                                <label for="projectinput6">Description Arabic </label>
                                                                                <textarea rows="5" type="text" id="projectinput6" class="form-control @if($route->complex_description) ckeditor @endif"
                                                                                          name="ar[description]"> {{$data->translate('ar')->description}}
                                                                        </textarea>
                                                                                @error('ar.description')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(in_array('fr', $locales))
                                                                        <div class="col-md-12  multiple-lang-fr">
                                                                            <div class="form-group">
                                                                                <label for="projectinput6">Description French </label>
                                                                                <textarea rows="5" type="text" id="projectinput6" class="form-control @if($route->complex_description) ckeditor @endif"
                                                                                          name="fr[description]">
                                                                     {{$data->translate('fr')->description}}
                                                                        </textarea>
                                                                                @error('fr.description')
                                                                                <div class='error-msg'>{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif

                                                            @endif


                                                            @if($route->has_image)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="projectinput13">Image</label>
                                                                        <input type="file" id="projectinput13" class="form-control"
                                                                               name="img"
                                                                               onchange="previewFile(this,'previewImg')">
                                                                    </div>
                                                                    <img id="previewImg" src="{{asset($data->image)}}"  width="150" height="150"/>
                                                                    @error('img')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                            @endif




                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1">Index</label>
                                                                    <input type="number"  class="form-control"  name="item_index" value="{{$data->item_index}}"
                                                                    >
                                                                    @error('item_index')
                                                                    <div class='error-msg'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            @if($route->has_parent)
                                                                <div class="col-md-12 ">
                                                                    <div class="form-group">
                                                                        <label for="projectinput1">Choose {{$route->parent_model}}</label>
                                                                            <?php $parentkey = $route->parent_key; ?>
                                                                        {!! Form::select('parentId', $parentData, $data->$parentkey  , ['class' => 'form-control select2', 'placeholder'=>'select record', 'required'=>'true']) !!}

                                                                        @error('parentId')
                                                                        <div class='error-msg'>{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            @endif


                                                        </div>
                                                        @can("List_".$route->model_name)
                                                            <div class="form-actions">
                                                                <a href="{{route($route->route)}}">
                                                                    <button type="button" class="btn btn-warning mr-1 button-cancel">
                                                                        <i class="ft-x"></i>&nbsp;Cancel

                                                                    </button>
                                                                </a>
                                                                @endcan
                                                                @can("Edit_".$route->model_name)
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="la la-check-square-o"></i>&nbsp;Update
                                                                    </button>
                                                                @endcan
                                                            </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    @endif
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

