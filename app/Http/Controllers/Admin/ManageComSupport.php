<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use ZipArchive;
use Illuminate\Support\Facades\File;

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

    public function strategic() {
        $this->token_auth = session()->get('token');
        $token_auth = $this->token_auth;

        return view('admin.managecomsupport.strategic', compact(['token_auth']));
    }

    public function strategicByType($slug, $type) {
        $this->token_auth = session()->get('token');
        $token_auth = $this->token_auth;

        $type_list = [
            ["id" => "article", "name" => "Articles"],
            ["id" => "logo", "name" => "Icon, Logo, Maskot BRIVO"],
            ["id" => "infographics", "name" => "Infographics"],
            ["id" => "transformation", "name" => "Transformation Journey"],
            ["id" => "podcast", "name" => "Podcast"],
            ["id" => "video", "name" => "Video Content"],
            ["id" => "instagram", "name" => "Instagram Content"],
        ];
        $key = array_search($type, array_column($type_list, 'id'));
        $tipe = $type_list[$key];

        return view('admin.managecomsupport.strategic-type', compact(['token_auth', 'slug', 'tipe']));
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
                        "totalRow"  => $hasil->totalRow
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

    public function getAllStrategicInitiative(Request $request) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";

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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative$query");
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
                        "totalRow"  => $hasil->totalRow
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

    public function strategicByProject(Request $request, $slug) {
        $this->token_auth = session()->get('token');
        try {

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative/project/$slug");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data;
                }else{
                    $data   = [];
                }
            }else{
                $data   = [];
            }
        } catch (\Throwable $th) {
            $data   = [];
        }

//        dd($data);
        return view('admin.managecomsupport.strategic-byproject', compact(['data', 'slug']));
    }

    public function getAllStrategicInitiativeByProjectAndType(Request $request, $slug, $type) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";

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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative/project/$slug/$type$query");
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
                        "totalRow"  => $hasil->totalRow,
                        "project"   => $hasil->project
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
                        "totalRow"  => $hasil->totalRow
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

    public function getDataUpdateImplementation($slug) {

        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/form_upload/implementation/$slug");
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
                    return response()->json([
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'data'      =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'data'      =>  $data
                ],200);
            }
        }catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 1';
            return response()->json([
                'data'      =>  $data
            ],200);
        }
    }

    public function createImplementation() {
//        dd(request()->all());
        request()->validate([
            'thumbnail'     => "required",
            'direktorat'    => "required",
            'divisi'        => 'required',
            'nama_project'  => 'required',
            'tgl_mulai'     => 'required',
            'pm'            => 'required',
            'emailpm'       => 'required',
            'restricted'    => 'required',
            'piloting'      => 'required',
            'rollout'       => 'required',
            'sosialisasi'   => 'required',
            'link'          => 'required',
            'checker'       => 'required',
            'signer'        => 'required',
        ]);
        if (isset(request()->id)) {
            $id = request()->id;
        } else {
            $id = "*";
        }
        if (request()->piloting == 1) {
            request()->validate([
                'deskripsi_piloting'    => 'required',
                'attach_piloting'    => 'required',
            ]);
            $desc_pilot   = request()->deskripsi_piloting;
            $attach_pilot   = request()->attach_piloting;
            $piloting         = 1;
        }else{
            $desc_pilot   = null;
            $attach_pilot   = null;
            $piloting         = 0;
        }

        if (request()->rollout == 1) {
            request()->validate([
                'deskripsi_rollout'    => 'required',
                'attach_rollout'    => 'required',
            ]);
            $desc_rollout   = request()->deskripsi_rollout;
            $attach_rollout   = request()->attach_rollout;
            $rollout         = 1;
        }else{
            $desc_rollout   = null;
            $attach_rollout   = null;
            $rollout         = 0;
        }

        if (request()->sosialisasi == 1) {
            request()->validate([
                'deskripsi_sosialisasi'    => 'required',
                'attach_sosialisasi'    => 'required',
            ]);
            $desc_sosialisasi   = request()->deskripsi_sosialisasi;
            $attach_sosialisasi   = request()->attach_sosialisasi;
            $sosialisasi         = 1;
        }else{
            $desc_sosialisasi   = null;
            $attach_sosialisasi   = null;
            $sosialisasi         = 0;
        }

        if (isset(request()->status)) {
            request()->validate([
                'tgl_selesai'    => 'required',
            ]);
            $tgl_selesai    = request()->tgl_selesai;
            $status         = 1;
        }else{
            $tgl_selesai    = null;
            $status         = 0;
        }

        if (request()->restricted == 1) {
            request()->validate([
                'user'          => 'required',
            ]);
            $user           = request()->user;
        }else{
            $user           = '-';
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
                'thumbnail'                 => request()->thumbnail,
                'direktorat'                => request()->direktorat,
                'divisi'                    => request()->divisi,
                'nama_project'              => request()->nama_project,
                'status'                    => $status,
                'tgl_mulai'                 => request()->tgl_mulai,
                'tgl_selesai'               => $tgl_selesai,
                'pm'                        => request()->pm,
                'emailpm'                   => request()->emailpm,
                'restricted'                => request()->restricted,
                'piloting'                  => $piloting,
                'rollout'                   => $rollout,
                'sosialisasi'               => $sosialisasi,
                'deskripsi_pilot'           => $desc_pilot,
                'attach_pilot'              => $attach_pilot,
                'deskripsi_rollout'         => $desc_rollout,
                'attach_rollout'            => $attach_rollout,
                'deskripsi_sosialisasi'     => $desc_sosialisasi,
                'attach_sosialisasi'        => $attach_sosialisasi,
                'project'                  => request()->link,
                'is_new_project'            => request()->is_new,
                'user'                      => $user,
                'checker'                   => request()->checker,
                'signer'                    => request()->signer,
                'token_bri'                 => session()->get('token_bri'),
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/managecommunication/implementation/upload/$id");
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
                    Session::flash('success','Implementasi Berhasil di Simpan');
                    return redirect('/managecommunication/implementation');
                }else{
                    if (isset($hasil->data->error_code)) {
                        if ($hasil->data->error_code == 0) {
                            Session::flash('error',$hasil->data->message);
                            return back()->withInput();
                        }else{
                            return back()->withErrors($hasil->data->message)->withInput();
                        }
                    }else{
                        Session::flash('error',$hasil->data->message);
                        return back()->withInput();
                    }
                }
            }else{
                Session::flash('error','Something Problem');
                return back()->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back()->withInput();
        }
    }

    public function createComInit(){
        // VALIDASI

//        dd(request()->all());
        request()->validate([
            'thumbnail'         => "required",
            'title'             => "required",
            'file_type'         => 'required',
            'deskripsi'         => 'required',
            'attach'            => 'required',
            'tgl_mulai'         => 'required',
        ]);

        if (isset(request()->id)) {
            $id = request()->id;
        } else {
            $id = "*";
        }
        if (request()->parent == 1) {
            request()->validate([
                'link'    => 'required',
                'divisi'  => 'required',
            ]);
            $divisi = request()->divisi;
            $project     = request()->link;
            $is_new = request()->is_new;
        }else{
            $divisi         = null;
            $project     = null;
            $is_new = 0;
        }

        if (isset(request()->status)) {
            request()->validate([
                'tgl_selesai'    => 'required',
            ]);
            $tgl_selesai    = request()->tgl_selesai;
            $status         = 1;
        }else{
            $tgl_selesai    = null;
            $status         = 0;
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
                'is_new_project'         => $is_new,
                'project'         => $project,
                'divisi'            => $divisi,
                'status'                    => $status,
                'tgl_mulai'                 => request()->tgl_mulai,
                'tgl_selesai'               => $tgl_selesai,
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

    public function download_attach() {
        $token      = session()->get('token');
        $files = request()->data;
        $zip = new ZipArchive;
        $fileName = 'attach_download.zip';

        if ($zip->open(public_path("storage/".$fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($files as $key => $value) {
//                dd(public_path('storage/'.$value['url_file']));
//                $files = File::files(public_path('storage/'.$value['url_file']));
                $relativeNameInZipFile = basename($value['tipe']."-".$value['nama']);
                $zip->addFile(public_path('storage/'.$value['url_file']), $relativeNameInZipFile);
            }

            $zip->close();
        }

        $headers = array(
            "Authorization: Bearer $token",
        );

        return response()->download(public_path("storage/".$fileName), $fileName.'-'.now()->timestamp, $headers);
//        dd(request()->all());
        /*return response()->json([
            'data'      =>  request()->data
        ],200);*/
    }
}
