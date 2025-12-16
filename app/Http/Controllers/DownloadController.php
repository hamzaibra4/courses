<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\EnrolledCourse;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function receipt($id)
    {
        $company  =Company::firstOrFail();
        $data = EnrolledCourse::findOrFail($id);
        $pdf = Pdf::loadView('pages.downloads.receipt',['data'=>$data, 'company'=>$company,'download'=>true]);
        return $pdf->download($data->enrollment_number.".pdf");
    }

    public function payment($id)
    {
        $company  =Company::firstOrFail();
        $data = Payment::findOrFail($id);
        $pdf = Pdf::loadView('pages.downloads.payment',['data'=>$data, 'company'=>$company,'download'=>true]);
        return $pdf->download($data->trx_number.".pdf");
    }






}
