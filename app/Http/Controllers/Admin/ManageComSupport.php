<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManageComSupport extends Controller
{
    public function index()
    {
        return redirect('managecommunication/communicationinitiative');
    }

    public function communicationInitiative()
    {
        return redirect('managecommunication/communicationinitiative/article');
    }

    public function implementation()
    {
        return redirect('managecommunication/implementation/piloting');
    }

    public function comInitType($type)
    {
        $type_list = (object) array(
            array("id" => "article", "name" => "Articles", "path" => "managecommunication/communicationinitiative/article"),
            array("id" => "logo", "name" => "Icon, Logo, Maskot BRIVO", "path" => "managecommunication/communicationinitiative/logo"),
            array("id" => "infographics", "name" => "Infographics", "path" => "managecommunication/communicationinitiative/infographics"),
            array("id" => "transformation", "name" => "Transformation Journey", "path" => "managecommunication/communicationinitiative/transformation"),
            array("id" => "podcast", "name" => "Podcast", "path" => "managecommunication/communicationinitiative/podcast"),
            array("id" => "video", "name" => "Video Content", "path" => "managecommunication/communicationinitiative/video"),
            array("id" => "instagram", "name" => "Instagram Content", "path" => "managecommunication/communicationinitiative/instagram"),
        );
        $type_array = array("article", "logo", "infographics", "transformation", "podcast", "video", "instagram");
        if (!in_array($type, $type_array)) {
            abort(404);
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('admin.managecomsupport.communication-initiative', compact(['type', 'type_list', 'sync_es', 'token_auth']));
    }

    public function getAllComInitiative(Request $request, $type) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";
            $order = 'asc';
            if($request->get('order')) {
                $query = $query."&order=".$request->get('order');
            }
            if($request->get('sort')) {
                $query = $query."&sort=".$request->get('sort');
            }

            if($request->get('search')) {
                $query = $query."&search=".$request->get('search');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/$type$query");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        'total'    =>  $hasil->total,
                        'totalNotFiltered' => $hasil->totalData,
                        "rows"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'    =>  0,
                        'total'    =>  0,
                        'totalNotFiltered' => $hasil,
                        'rows'      =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'status'    =>  0,
                    'total'    =>  0,
                    'totalNotFiltered' => 0,
                    'rows'      =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'total'    =>  0,
                'totalNotFiltered' => 0,
                'rows'      =>  $data
            ],200);
        }
    }

    public function setStatusComInit($status, $id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/status/$status/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   $status.' Gagal';
                    $data['toast']    =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   $status.' Gagal';
                $data['toast']    =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function deleteComInit($id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/delete/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Delete Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Delete Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function implementationStep($step)
    {
        $step_list = (object) array(
            array("id" => "piloting", "name" => "Piloting", "path" => "managecommunication/implementation/piloting"),
            array("id" => "roll-out", "name" => "Roll Out", "path" => "managecommunication/implementation/roll-out"),
            array("id" => "sosialisasi", "name" => "Sosialisasi", "path" => "managecommunication/implementation/sosialisasi")
        );
        $step_array = array("piloting", "roll-out", "sosialisasi");
        if (!in_array($step, $step_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('admin.managecomsupport.implementation', compact(['step', 'step_list', 'sync_es', 'token_auth']));
    }

    public function getAllImplementation(Request $request, $step) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";
            $order = 'asc';
            if($request->get('order')) {
                $query = $query."&order=".$request->get('order');
            }
            if($request->get('sort')) {
                $query = $query."&sort=".$request->get('sort');
            }

            if($request->get('search')) {
                $query = $query."&search=".$request->get('search');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/implementation/$step$query");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        'total'    =>  $hasil->total,
                        'totalNotFiltered' => $hasil->totalData,
                        "rows"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'    =>  0,
                        'total'    =>  0,
                        'totalNotFiltered' => 0,
                        'rows'      =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'status'    =>  0,
                    'total'    =>  0,
                    'totalNotFiltered' => 0,
                    'rows'      =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'total'    =>  0,
                'totalNotFiltered' => 0,
                'rows'      =>  $data
            ],200);
        }
    }

    public function setStatusImplementation($status, $id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/implementation/status/$status/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   $status.' Gagal';
                    $data['toast']    =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   $status.' Gagal';
                $data['toast']    =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function deleteImplementation($id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/implementation/delete/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Delete Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Delete Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function uploadForm($type, $slug="*") {

        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/form_upload/$type/$slug");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
//             dd($hasil);
            $tgl_mulai = Carbon::now();
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data;
                }else{
                    $data   = [];
                }
            }else{
                $data  =  [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }
//        dd($data);
        if ($type == 'content') {
            return view('admin.managecomsupport.content-upload',compact(['data']));
        } else if($type == 'implementation') {
            return view('admin.managecomsupport.implementation-upload',compact(['data']));
        }  else {
            abort(404);
            return null;
        }
    }

    public function createComInit(){
        // TODO : SAVE
        // VALIDASI

//        dd(request()->all());
        request()->validate([
            'thumbnail'         => "required",
            'title'             => "required",
            'file_type'         => 'required',
            'deskripsi'         => 'required',
            'attach'            => 'required',
        ]);

        if (isset(request()->id)) {
            $id = request()->id;
        } else {
            $id = "*";
        }
        if (request()->parent == 1) {
            request()->validate([
                'link'    => 'required',
            ]);
            $project_id     = request()->link;
        }else{
            $project_id     = null;
        }

        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            $postData = [
                'thumbnail'         => request()->thumbnail,
                'title'         => request()->title,
                'file_type'         => request()->file_type,
                'deskripsi'         => request()->deskripsi,
                'project_id'         => request()->project_id,
                'attach'         => request()->attach,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/managecommunication/content/upload/$id");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    Session::flash('success','Content Berhasil di Simpan');
                    return redirect('/managecommunication');
                }else{
                    if (isset($hasil->data->error_code)) {
                        if ($hasil->data->error_code == 0) {
                            session()->flash('error',$hasil->data->message);
                            return back()->withInput();
                        }else{
                            return back()->withErrors($hasil->data->message)->withInput();
                        }
                    }else{
                        session()->flash('error',$hasil->data->message);
                        return back()->withInput();
                    }
                }
            }else{
                session()->flash('error','Something Problem');
                return back()->withInput();
            }
        }catch (\Throwable $th) {
            session()->flash('error',"Something Error, Try Again Please");
            return back()->withInput();
        }
    }
}
