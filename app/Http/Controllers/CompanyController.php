<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Company;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(GenericController $generic){
        $this->middleware('auth');
        $this->genericController = $generic;
    }
    public function index()
    {
        {
            $user = Auth::user();
            if (!$user->can('List_Company')) {
                abort(403);
            }
            $companies = Company::all();
            return view('pages.company.list', compact('companies'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        {
            $user = Auth::user();
            if (!$user->can('Edit_Company')) {
                abort(403);
            }
            $company =Company::findOrFail($id);
            return view('pages.company.Add', compact('company'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->can('Edit_Company')) {
            abort(403);
        }
        $request->validate([
           'name'=>'required',
           'email'=>'required',
           'address'=>'required',
           'telephone'=>'required',
        ]);

        $company=Company::find($id);
        $company->name=$request->name;
        $company->email=$request->email;
        $company->address=$request->address;
        $company->telephone=$request->telephone;
        $company->invoice_prefix=$request->invoice_prefix;
        $company->payment_prefix=$request->payment_prefix;
        $imageName = 'logo';
        $path = $this->genericController->uploadImage($request, $imageName);
        if ($path) {
            $company->logo = $path;
        }
        $imageName = 'signature_image';
        $path = $this->genericController->uploadImage($request, $imageName);
        if ($path) {
            $company->signature_image = $path;
        }
        $company->save();
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
