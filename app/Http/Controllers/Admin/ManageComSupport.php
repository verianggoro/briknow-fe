<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManageComSupport extends Controller
{
    public function index()
    {
        return redirect('mannagecommunication/communicationinitiative');
    }

    public function communicationInitiative()
    {
        return redirect('mannagecommunication/communicationinitiative/article');
    }

    public function comType($type)
    {
        $type_list = (object) array(
            array("id" => "article", "name" => "Articles", "path" => "mannagecommunication/communicationinitiative/article"),
            array("id" => "logo", "name" => "Icon, Logo, Maskot BRIVO", "path" => "mannagecommunication/communicationinitiative/logo"),
            array("id" => "infographics", "name" => "Infographics", "path" => "mannagecommunication/communicationinitiative/infographics"),
            array("id" => "transformation", "name" => "Transformation Journey", "path" => "mannagecommunication/communicationinitiative/transformation"),
            array("id" => "podcast", "name" => "Podcast", "path" => "mannagecommunication/communicationinitiative/podcast"),
            array("id" => "video", "name" => "Video Content", "path" => "mannagecommunication/communicationinitiative/video"),
            array("id" => "instagram", "name" => "Instagram Content", "path" => "mannagecommunication/communicationinitiative/instagram"),
        );
        $type_array = array("article", "logo", "infographics", "transformation", "podcast", "video", "instagram");
        if (!in_array($type, $type_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
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

    public function setStatus($status, $id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

//            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/status/$id");
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

    public function delete($id) {
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

    public function upload_form($slug) {
        $type_file = (object) array(
            array("value" => "article", "name" => "Article"),
            array("value" => "logo", "name" => "Icon, Logo, Maskot BRIVO"),
            array("value" => "infographics", "name" => "Infographics"),
            array("value" => "transformation", "name" => "Transformation Journey"),
            array("value" => "podcast", "name" => "Podcast"),
            array("value" => "video", "name" => "Video Content"),
            array("value" => "instagram", "name" => "Instagram Content"),
        );

        if ($slug == 'communicationinitiative') {
            return view('admin.managecomsupport.cominitiative-upload',compact(['type_file']));
        } else if($slug == 'strategicinitiative') {
            return back();
        } else if($slug == 'implementation') {
            return back();
        }  else {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
    }

    public function create_com_init(){
        // TODO : SAVE
        // VALIDASI
        /*request()->validate([
            'photo'         => "required"
        ]);*/

        /*$file = request()->file("file");
        $s = array();
        foreach($file as $f){
            // here is your file object
//            dd($f->getClientOriginalName());
            $s[] = $f->getClientOriginalName();
        }*/
        dd(request()->all());
        return response()->json([
            'status'    =>  0,
            'data'      =>  $s
        ],200);

        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            $postData = [
                'photo'         => request()->photo,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/kontribusi/create');
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
                    if (request()->project == 0) {
                        Session::flash('success','Project Berhasil di Simpan');
                    }else{
                        Session::flash('success','Project Berhasil Dikirimkan');
                    }
                    return redirect('/myproject');
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
