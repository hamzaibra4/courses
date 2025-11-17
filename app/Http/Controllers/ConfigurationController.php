<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $genericController;
    public function __construct(GenericController $generic){
        $this->middleware('auth');
        $this->genericController = $generic;
    }

    public function index($route)
    {
        $routeData = ConfigurationTable::where('route',$route)->firstOrFail();
        $modelName = $routeData->model_name;
        $user = Auth::user();
        if (!$user->can('List_'.$modelName)) {
            abort(403);
        }
        $modelClass = "\App\\Models\\".$modelName;
        if(!class_exists($modelClass)){
            abort(403, "Model name does not exist");
        }
        $data = $modelClass::all();
        return view('pages.configuration.List')->with('route',$routeData)->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($route)
    {
        $routeData = ConfigurationTable::where('route',$route)->firstOrFail();
        $modelName = $routeData->model_name;
        $user = Auth::user();
        if (!$user->can('Add_'.$modelName)) {
            abort(403);
        }
        if($routeData->has_add){
            $parentData = [];
            if($routeData->has_parent){
                $modelName2 = $routeData->parent_model;
                $modelClass2= "\App\\Models\\".$modelName2;
                if(!class_exists($modelClass2)){
                    abort(403, "Model name does not exist");
                }
                $parentData = $modelClass2::all()->pluck('name','id');
            }

            return view('pages.configuration.Add')->with('route',$routeData)->with('parentData',$parentData);
        }else{
            return abort(403);
        }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($route,Request $request)
    {
        $routeData = ConfigurationTable::where('route',$route)->firstOrFail();
        $modelName = $routeData->model_name;
        $user = Auth::user();
        if (!$user->can('Add_'.$modelName)) {
            abort(403);
        }
        if($routeData->has_add){
            $modelName = $routeData->model_name;
            $modelClass = "\App\\Models\\".$modelName;
            if(!class_exists($modelClass)){
                abort(403, "Model name does not exist");
            }
            $data = new $modelClass();
            $validationRule = [];
            if($routeData->has_translation) {
                foreach (config('translatable.locales') as $locale) {
                    if (is_array($locale)) continue;
                    $validationRule[$locale . '.name'] = 'required|unique:' . $routeData->database_translation_name . ",name";
                }
            }else{
                $validationRule['en.name']='required|unique:'.$routeData->database_name.",name";
            }

            if($routeData->has_image) {
                $validationRule['img']='required';
            }


            $request->validate(
                $validationRule,
                [   'required'=>"This field is required",
                    'unique'=>"This name is already taken"
                ]
            );

            $path= null;
            if($routeData->has_image) {
                $imageColumnName = 'img';
                $path = $this->genericController->uploadImage($request, $imageColumnName);
            }
            if ($path) {
                $data->image=$path;
            }

            if($routeData->has_translation){
                foreach (config('translatable.locales') as $locale) {
                    $name = $locale.'.name';
                    $nameVal=$request[$name];
                    if(is_null($nameVal)){
                        $nameVal='NA';
                    }
                    $data->translateOrNew($locale)->name = $nameVal;


                    $name = $locale.'.description';
                    $nameVal=$request[$name];
                    if(is_null($nameVal)){
                        $nameVal='NA';
                    }
                    $data->translateOrNew($locale)->description = $nameVal;


                    $name = $locale.'.add1';
                    $nameVal=$request[$name];
                    if(is_null($nameVal)){
                        $nameVal='NA';
                    }
                    $data->translateOrNew($locale)->additional_field1 = $nameVal;


                    $name = $locale.'.add2';
                    $nameVal=$request[$name];
                    if(is_null($nameVal)){
                        $nameVal='NA';
                    }
                    $data->translateOrNew($locale)->additional_field2 = $nameVal;



                }
            }else{
                $data->name = $request['en.name'];
                $data->description = $request['en.description'];

                if ($routeData->has_additional_field1 && $routeData->additional_field1_name) {
                    $data->additional_field1 = $request['en.add1'];
                }

                if ($routeData->has_additional_field2 && $routeData->additional_field2_name) {
                    $data->additional_field2 = $request['en.add2'];
                }
            }

            if($routeData->has_parent){
                $parent = $routeData->parent_key;
                $data->$parent = $request['parentId'] ;
            }

            $data->item_index=$request['item_index'];
            $data->save();
            return redirect()->route($routeData->route);
        }else{
            return abort(403);
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$route)
    {
        $routeData = ConfigurationTable::where('route',$route)->firstOrFail();
        $modelName = $routeData->model_name;
        $user = Auth::user();
        if (!$user->can('Edit_'.$modelName)) {
            abort(403);
        }
        $modelClass = "\App\\Models\\".$modelName;
        if(!class_exists($modelClass)){
            abort(403, "Model name does not exist");
        }
        $data=$modelClass::find($id);

        $parentData= [];
        if($routeData->has_parent){
            $modelName2 = $routeData->parent_model;
            $modelClass2= "\App\\Models\\".$modelName2;
            if(!class_exists($modelClass2)){
                abort(403, "Model name does not exist");
            }
            $parentData = $modelClass2::all()->pluck('name','id');
        }
        return view('pages.configuration.Add')->with('route',$routeData)->with('data',$data)->with('parentData',$parentData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request  $request ,$route)
    {
        $routeData = ConfigurationTable::where('route',$route)->firstOrFail();
        $modelName = $routeData->model_name;
        $user = Auth::user();
        if (!$user->can('Edit_'.$modelName)) {
            abort(403);
        }
        $modelClass = "\App\\Models\\".$modelName;
        if(!class_exists($modelClass)){
            abort(403, "Model name does not exist");
        }
        $data=$modelClass::find($id);
        $validationRule = [];

        $path= null;
        if($routeData->has_image) {
            $imageColumnName = 'img';
            $path = $this->genericController->uploadImage($request, $imageColumnName);
        }

        if($routeData->has_translation) {
            foreach (config('translatable.locales') as $locale) {
                if (is_array($locale)) continue;
                $validationRule[$locale.'.name']='required|unique:'.$routeData->database_translation_name.",name,".$data->translate($locale)->id;
            }
        }else{
            $validationRule['en.name']='required|unique:'.$routeData->database_name.",name,".$data->id;
        }

        $request->validate(
            $validationRule,
            [   'required'=>"This field is required",
                'unique'=>"The Name is already taken" ]
        );

        if ($path) {
            $data->image=$path;
        }

        if($routeData->has_translation) {
            foreach (config('translatable.locales') as $locale) {
                $name = $locale . '.name';
                $nameVal = $request[$name];
                if (is_null($nameVal)) {
                    $nameVal = 'NA';
                }
                $data->translateOrNew($locale)->name = $nameVal;


                $name = $locale.'.description';
                $nameVal=$request[$name];
                if(is_null($nameVal)){
                    $nameVal='NA';
                }
                $data->translateOrNew($locale)->description = $nameVal;


                $name = $locale.'.add1';
                $nameVal=$request[$name];
                if(is_null($nameVal)){
                    $nameVal='NA';
                }
                $data->translateOrNew($locale)->additional_field1 = $nameVal;


                $name = $locale.'.add2';
                $nameVal=$request[$name];
                if(is_null($nameVal)){
                    $nameVal='NA';
                }
                $data->translateOrNew($locale)->additional_field2 = $nameVal;


            }
        }else{
            $data->name=$request['en.name'];
            $data->description=$request['en.description'];
            $data->additional_field1=$request['en.add1'];
            $data->additional_field2=$request['en.add2'];
        }

        if($routeData->has_parent){
            $parent = $routeData->parent_key;
            $data->$parent = $request['parentId'] ;
        }


        $data->item_index=$request['item_index'];
        $data->save();
        return redirect()->route($routeData->route);
    }

    public function destroy($id,$route)
    {
        $routeData = ConfigurationTable::where('route',$route)->firstOrFail();
        $modelName = $routeData->model_name;
        $user = Auth::user();
        if (!$user->can('Delete_'.$modelName)) {
            abort(403);
        }
        if($routeData->has_delete){

            $modelName = $routeData->model_name;
            $modelClass = "\App\\Models\\".$modelName;
            if(!class_exists($modelClass)){
                abort(403, "Model name does not exist");
            }
            $data=$modelClass::find($id);
            $parent = $routeData->relationchip_name;
            $msg = 'Deleted Successfully!';
            $code='200';

            if(!is_null($parent)){
                if(count($data->$parent) > 0 ){
                    $msg = 'You cannot delete this record because it has a child relationship!';
                    $code='500';
                }else{
                    $data->delete();
                }
            }else{
                $data->delete();
            }
            return response()->json([
                'code' => $code,
                'msg'=>$msg
            ]);
        }else{
            return response()->json([
                'code' => 500,
                'msg'=>"No access"
            ]);
        }

    }
}
