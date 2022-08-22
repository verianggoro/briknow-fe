<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ManageLessonLearned extends Controller
{
    public function index()
    {
        return redirect('managelesson/review');
    }

    public function review()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageproject/review');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $this->data = $hasil->data->bahan;
                    $sync_es = $hasil->data->sync_es;
                    $projects= [];
                    $projeks = [];

                    // divisi
                    foreach ($this->data as $proj) {
                        $projects[$proj->divisi->id] = $proj->divisi->divisi;
                        foreach ($proj->consultant as $cons) {
                            $projeks[$cons->id] = $cons->nama;
                        }
                    }
                    $divisi_unik = array_unique($projects);
                    // nama project
                    $nama_unik = array_unique($projeks);
                }else{
                    $sync_es = 0;
                    $this->data = [];
                    session()->flash('error',$hasil->data->message);
                    return back();
                }
            }else{
                $sync_es = 0;
                $this->data = [];
                session()->flash('error',$hasil->data->message);
                return back();
            }
            $token_auth = $this->token_auth;
            // $data = $this->data;
            // $data = $this->paginate($data);
            // $data->withPath('/manageproject/review');
            // dd($nama_unik);
            // dd($data);

            // return view('admin.manageproject.review', compact(['data', 'token_auth', 'divisi_unik', 'nama_unik']));
            return view('admin.managelessonlearned.review-lesson', compact(['token_auth', 'divisi_unik', 'nama_unik', 'sync_es']));
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
            return back();
        }
    }
}