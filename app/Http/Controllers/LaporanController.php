<?php

namespace App\Http\Controllers;

use App\Exports\AllPerformanceExport;
use App\Exports\ComInitTop5Export;
use App\Exports\ImpTop5Export;
use App\Exports\LessonTop5Export;
use App\Exports\ProyekTop5Export;
use App\Exports\StrategicTop5Export;
use App\Exports\VendorTop5Export;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use stdClass;

class LaporanController extends Controller
{
    public function proyektop5(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new ProyekTop5Export(), 'Proyek_Top_5_'.$date.'.xlsx');
    }

    public function proyektop5pdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/proyektop5');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $pdf = PDF::loadview('export.proyektop5export',['data'=>$data])->setPaper('a4', 'landscape');
    	return $pdf->download('Proyek_Top_5_'.$date.'.pdf');
    }

    public function vendortop5(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new VendorTop5Export(), 'Vendor_Top_5_'.$date.'.xlsx');
    }

    public function vendortop5pdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/vendortop5');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $pdf = PDF::loadview('export.vendortop5export',['data'=>$data])->setPaper('a4', 'landscape');
    	return $pdf->download('vendor_Top_5_'.$date.'.pdf');
    }

    public function lessontop5(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new LessonTop5Export(), 'LessonLearned_Top_5_'.$date.'.xlsx');
    }

    public function lessontop5pdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/cntlessonbytahap');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $pdf = PDF::loadview('export.lessontop5export',['data'=>$data])->setPaper('a4', 'landscape');
        return $pdf->download('LessonLearned_Top_5_'.$date.'.pdf');
//        return view('export.lessontop5export', compact(['data']));
    }

    public function comInittop5(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new ComInitTop5Export(), 'CommunicationInitiative_Top_5_'.$date.'.xlsx');
    }

    public function comInittop5pdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/cntComInitiative');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $pdf = PDF::loadview('export.cominittop5export',['data'=>$data])->setPaper('a4', 'landscape');
        return $pdf->download('CommunicationInitiative_Top_5_'.$date.'.pdf');
//        return view('export.lessontop5export', compact(['data']));
    }

    public function strategictop5(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new StrategicTop5Export(), 'StrategicInitiative_Top_5_'.$date.'.xlsx');
    }

    public function strategictop5pdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/strategictopfive');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $pdf = PDF::loadview('export.strategictop5export',['data'=>$data])->setPaper('a4', 'landscape');
        return $pdf->download('StrategicInitiative_Top_5_'.$date.'.pdf');
//        return view('export.lessontop5export', compact(['data']));
    }

    public function imptop5(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new ImpTop5Export(), 'Implementation_Top_5_'.$date.'.xlsx');
    }

    public function imptop5pdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/cntImplementation');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $pdf = PDF::loadview('export.imptop5export',['data'=>$data])->setPaper('a4', 'landscape');
        return $pdf->download('Implementation_Top_5_'.$date.'.pdf');
//        return view('export.lessontop5export', compact(['data']));
    }

    public function allexcel(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new AllPerformanceExport(), 'AllPerformance_Top_5_'.$date.'.xlsx');
    }

    public function allpdf(){
        $date   =   Carbon::now()->format('d F Y');

        // get data
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/allPerformance');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
//             dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $dataProject = $hasil->data->dataProject;
                    $dataVendor = $hasil->data->dataVendor;
                    $dataLesson = $hasil->data->dataLesson;
                    $dataCom = $hasil->data->dataCom;
                    $dataStr = $hasil->data->dataStr;
                    $dataImp = $hasil->data->dataImp;
//                    $dataTag = $hasil->data->dataTag;
                    $dataTag =   [];
                    foreach ($hasil->data->dataTag->tags as $item) {
                        $obj        =   new stdClass;
                        $obj->nama  =   $item->nama;
                        $obj->keyword_log_count  =   $item->keyword_log_count;
                        $temp       =   "";

                        foreach ($hasil->data->dataTag->relateds as $related) {
                            if ($related->nama == $item->nama){
                                if($temp == ""){
                                    $temp = $related->nama_project;
                                }else{
                                    $temp .= ", ".$related->nama_project;
                                }
                            }
                        }
                        $obj->related   =  $temp;
                        $dataTag[]       =  $obj;
                    }
                }else{
                    $dataProject = [];
                    $dataVendor = [];
                    $dataLesson = [];
                    $dataCom = [];
                    $dataStr = [];
                    $dataImp = [];
                    $dataTag = [];
                }
            }else{
                $dataProject = [];
                $dataVendor = [];
                $dataLesson = [];
                $dataCom = [];
                $dataStr = [];
                $dataImp = [];
                $dataTag = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $dataProject = [];
            $dataVendor = [];
            $dataLesson = [];
            $dataCom = [];
            $dataStr = [];
            $dataImp = [];
            $dataTag = [];
        }

        $pdf = PDF::loadview('export.allperformanceexport',['dataProject'=>$dataProject, 'dataVendor'=>$dataVendor, 'dataLesson'=>$dataLesson, 'dataCom'=>$dataCom, 'dataStr'=>$dataStr, 'dataImp'=>$dataImp, 'dataTag'=>$dataTag])->setPaper('a4', 'landscape');
        return $pdf->download('AllPerformance_Top_5_'.$date.'.pdf');
//        return view('export.allperformanceexport', compact(['dataProject', 'dataVendor', 'dataLesson', 'dataCom']));
    }
}
