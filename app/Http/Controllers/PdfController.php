<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PdfController extends Controller
{
    public function __construct(GenericController $generic){
        $this->middleware('auth');
        $this->genericController = $generic;
    }

    public function show($id)
    {
        $pdf = MaterialPdf::findOrFail($id);
        return view('pdf.view', compact('pdf'));
    }

    public function stream($id)
    {
        $pdf = MaterialPdf::findOrFail($id);

        abort_unless(auth()->check() && Storage::disk('local')->exists($pdf->path), 403);

        $absolutePath = Storage::disk('local')->path($pdf->path);

        return response()->file($absolutePath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
            'Pragma'              => 'no-cache',
        ]);
    }
}
