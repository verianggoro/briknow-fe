<?php

namespace App\Http\Controllers;

use App\Exports\ProyekTop5Export;
use App\Exports\VendorTop5Export;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
}
