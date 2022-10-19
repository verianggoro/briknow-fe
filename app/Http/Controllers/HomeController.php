<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use stdClass;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public $raw;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public $rekomendasi;
    public $cominitiative;
    public $owner_project;
    public $consultant;
    public $consultant_filter;
    public $suggest;
    public $direktorat;
    public $divisi;

    public function __construct()
    {
    }

    public function default(){
        $this->rekomendasi   = [];
        $this->owner_project = [];
        $this->consultant    = [];
    }

    public function index(){
        $leaderboard            = [];
        $token = session('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/beranda');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $this->rekomendasi      = $hasil->data->rekomendasi;
                    $this->owner_project    = $hasil->data->owner_project;
                    $this->consultant       = $hasil->data->consultant;
                    $this->consultant_filter       = $hasil->data->consultant_filter;
                    $this->suggest          = $hasil->data->suggest;
                    $leaderboard            = $hasil->data->leaderboard;
                    $this->cominitiative    = $hasil->data->cominitiative;
                    $this->direktorat       = $hasil->data->direktorat;
                    $this->divisi           = $hasil->data->divisi;
                }else{
                    $this->default();
                }
            }else{
                $this->default();
                if(isset($hasil->message)){
                    if ($hasil->message == "Unauthenticated.") {
                        session()->flush();
                        session()->flash('error','Session Time Out');
                        return redirect('/login');
                    }
                }
            }
        }catch (\Throwable $th) {
            $this->default();
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
        }

        $rekomendasi    = $this->rekomendasi;
        $owner_project  = $this->owner_project;
        $consultant     = $this->consultant;
        $consultant_filter     = $this->consultant_filter;
        $suggest        = $this->suggest;
        $recominitiative = $this->cominitiative;
        $direk          = $this->direktorat;
        $divisi         = $this->divisi;

        // dd($leaderboard);
        return view('index',compact('rekomendasi', 'direk', 'divisi', 'recominitiative','owner_project','consultant','suggest','leaderboard', 'consultant_filter'));
    }

    public function indexPOST(){
        //try {
            $key_bristar    = request()->input('key')??NULL;
            $user_bristar   = request()->input('user')??NULL;

            if ($key_bristar <> NULL && $user_bristar <> NULL) {
                //try {
                    $ch = curl_init();
                    $headers  = [
                                'Content-Type: application/json',
                                'Accept: application/json',
                            ];
                    $postData = [
                        'key'    => $key_bristar,
                        'user'   => $user_bristar,
                        'app_id' => config('app.api_app_id'),
                        'ip'     => $_SERVER['REMOTE_ADDR']
                    ];
                    // dd($postData);
                    curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/proses_bri_stars');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result     = curl_exec ($ch);
                    $hasil = json_decode($result);
                    //dd($result); //debugging hasil BE, di BE pake return
                    if (isset($hasil->status)) {
                        if ($hasil->status == 0) {
                            Session::flash('error',$hasil->data->message);
                        }else{
                            // refresh session
                            Session::flush();
                            $temp['id']                 = $hasil->data->id;
                            $temp['avatar_id']          = $hasil->data->avatar_id;
                            $temp['exp']                = $hasil->data->exp;
                            $temp['level_id']           = $hasil->data->level_id;
                            $temp['level_name']         = $hasil->data->level_name;
                            $temp['name']               = $hasil->data->name;
                            $temp['personal_number']    = $hasil->data->personal_number;
                            $temp['username']           = $hasil->data->username;
                            $temp['email']              = $hasil->data->email;
                            $temp['direktorat']         = $hasil->data->direktorat;
                            $temp['divisi']             = $hasil->data->divisi;
                            $temp['last_login_at']      = $hasil->data->last_login_at;
                            $temp['login_at']           = $hasil->data->login_at;
                            $temp['token']              = $hasil->data->token;
                            $temp['token_bri']          = $hasil->data->token_bri;
                            $temp['role']               = $hasil->data->role;
                            session($temp);
                            session(['logged_in' => true]);
                            Session::flash('term', true);

                            return redirect('/');
                        }
                    }else{
                        session()->flush();
                        Session::flash('error','Failed to connect BRISTAR Server');
                        return redirect('/login');
                    }
                //}catch (\Throwable $th) {
                //    session()->flush();
                //    session()->flash('error','Login Via Bristars Failed');
                //    return redirect('/login');
                //}
            }

            if (!session('logged_in')){
                session()->flush();
                session()->flash('error','Login Via Bristars Failed');
                return redirect('/login');
            }
       // } catch (\Throwable $th) {
        //    session()->flash('error','Login Via Bristars Failed');
        //    return redirect('/login');
        //}
    }

    public function dashboard(){
        $this->getDataVisitor();
        // dd($this->raw);
        $data = $this->raw->data;
        // dd($data);
        return view('dashboard', compact(['data']));
        // ON-OFF
        // return view('dashboard_new', compact(['data']));
    }

    public function getDataVisitor(){
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/dashboard/visitor');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                $this->raw = $hasil->data;
            }else{
                session()->flash('error',$hasil->data->message);
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error','Get Data Bermasalah , Silahkan Coba Lagi');
        }
    }

    public function topfive_vendor(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/topfivevendor");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function topfive_project(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/topfiveproject");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function suggest($key){
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/suggestionberanda/'.$key);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
            $data['message']    =   'Something Went Wrong';
            return response()->json([
                "status"    =>  0,
                "data"      =>  $data
            ],200);
        }


        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function profile(){
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/profile');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data           = $hasil->data->data;
                $dataPrj        = $hasil->data->projects;
                $dataAct        = $hasil->data->activities;
                $history_activity = $hasil->data->history_activities;
                $dataLevel      = $hasil->data->levels;
                $count_avatar   = $hasil->data->count_avatar;
                $level_user     = $hasil->data->level_user;
                $level          = $hasil->data->level;

                return view('profile', compact(['data', 'dataPrj', 'dataAct', 'dataLevel', 'count_avatar','level_user','level','history_activity']));
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function profileuser($pn){
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/profile/'.$pn);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data           = $hasil->data->data;
                    $dataPrj        = $hasil->data->projects;
                    $dataAct        = $hasil->data->activities;
                    $dataLevel      = $hasil->data->levels;
                    $count_avatar   = $hasil->data->count_avatar;
                    $history_activity = $hasil->data->history_activities;
                    $level_user     = $hasil->data->level_user;
                    $level          = $hasil->data->level;

                    return view('profile', compact(['data', 'dataPrj', 'dataAct', 'dataLevel' , 'count_avatar', 'level_user','level', 'history_activity']));
                }else{
                    session()->flash('error', $hasil->data->message);
                    return redirect()->back();
                }
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function gamification()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/gamification');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data = $hasil->data->data;
                return view('gamification', compact(['data']));
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function avatar()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/profile');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data           =   $hasil->data->data;
                $avatar         =   $hasil->data->avatar;

                return view('avatar', compact(['data','avatar']));
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function changeavatar()
    {
        $this->token_auth   = session()->get('token');

        $postData = [
            "avatar"       => request()->avatar,
        ];

        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/changeavatar');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if (isset($hasil->status)) {
                if($hasil->status == 1){
                    session::forget('avatar_id');
                    session::put('avatar_id', $hasil->data->data);

                    return response()->json($hasil);
                }else{
                    return response()->json([
                        "status"    =>  0,
                        "message"   =>  "Perbarui Avatar gagal",
                    ],400);
                }
            }else{
                return response()->json([
                    "status"    =>  0,
                    "message"   =>  "Perbarui Avatar gagal",
                ],400);
            }
            return response()->json($hasil);
        }catch (\Throwable $th) {
            return response()->json([
                "status"    =>  0,
                "message"   =>  "something wrong",
            ],400);
        }
    }

    public function editprof()
    {
        $token_auth = session()->get('token');
        try {
            request()->validate([
                'name' => "required",
                'nickname' => "required",
                'divisi' => "required",
            ]);


            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            $postData = [
                'name'      => request()->name,
                'username'  => request()->nickname,
                'divisi'    => request()->divisi,
                'email'     => request()->email
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/editprofiles');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    session::forget('username');
                    session::forget('name');
                    session::forget('divisi');
                    session::forget('direktorat');
                    session::forget('email');
                    session::put('username', $hasil->data->username);
                    session::put('name', $hasil->data->name);
                    session::put('divisi', $hasil->data->divisis->id);
                    session::put('direktorat', $hasil->data->divisis->id);
                    session::put('email', $hasil->data->email);
                    return response()->json([
                        "status"    =>  1,
                        "data"      =>  $hasil
                    ],200);
                }else{
                    return response()->json([
                        "status"    =>  0,
                        "data"      =>  'Gagal'
                    ],200);
                }
            }else{
                return response()->json([
                    "status"    =>  0,
                    "data"      =>  'Gagal'
                ],200);
            }
        }catch (\Throwable $th) {
            $out=[];
            $data['message']    =   'Something Went Wrong';
            return response()->json([
                "status"    =>  0,
                "data"      =>  $data
            ],200);
        }
    }

    public function congrats_update(){
        $token_auth = request()->token;
        $id         = request()->id;

        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            $postData = [
                'id'    => $id
            ];
            // dd(json_encode($postData));
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/congrats');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            return response()->json($hasil);
        }catch (\Throwable $th) {
            $data['message']    =   'update Data Gagal';
            $data['data']       =   0;
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    // get cnt lesson learned by tahap
    public function cntLessonByTahap(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/cntlessonbytahap");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function cntStraInitiative(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/cntStrategicInitiative");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function cntComInitiative(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/cntComInitiative");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function cntImplementation(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/cntImplementation");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }
}
