<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyLessonLearnedController extends Controller
{
    public function index()
    {
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/mylessonlearned');
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
                    foreach ($data->data as $lesson){
                        $shortDetail = strlen($lesson->detail) > 40 ? substr($lesson->detail,0,40)."..." : $lesson->detail;
                        $shortLessonTitle = strlen($lesson->lesson_learned) > 30 ? substr($lesson->lesson_learned, 0, 40)."..." : $lesson->lesson_learned;

                        $lesson->detail = $shortDetail;
                        $lesson->lesson_learned = $shortLessonTitle;
                    }

                    // dd($data);
                    return view('mylessonlearned', compact(['data']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    $data= [];

                    return view('mylessonlearned', compact(['data']));
                }
            }else{
                session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
                $data= [];
                return back();
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
            $data= [];

            return view('mylessonlearned', compact(['data']));
        }
    }
}
