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
        return redirect('mannagecommunication/communicationinitiative/artikel');
    }

    public function comType($type)
    {
        $type_list = (object) array(
            array("id" => "artikel", "name" => "Artikel", "path" => "mannagecommunication/communicationinitiative/artikel"),
            array("id" => "logo", "name" => "Icon, Logo, Maskot BRIVO", "path" => "mannagecommunication/communicationinitiative/logo"),
            array("id" => "infographics", "name" => "Infographics", "path" => "mannagecommunication/communicationinitiative/infographics"),
            array("id" => "transformation", "name" => "Transformation Journey", "path" => "mannagecommunication/communicationinitiative/transformation"),
            array("id" => "podcast", "name" => "Podcast", "path" => "mannagecommunication/communicationinitiative/podcast"),
            array("id" => "video", "name" => "Video Content", "path" => "mannagecommunication/communicationinitiative/video"),
            array("id" => "instagram", "name" => "Instagram Content", "path" => "mannagecommunication/communicationinitiative/instagram"),
        );
        $type_array = array("artikel", "logo", "infographics", "transformation", "podcast", "video", "instagram");
        if (!in_array($type, $type_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        // $data = $this->data;
        // $data = $this->paginate($data);
        // $data->withPath('/manageproject/review');
        // dd($nama_unik);
        // dd($data);

        // return view('admin.manageproject.review', compact(['data', 'token_auth', 'divisi_unik', 'nama_unik']));
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


            /*return response()->json([
                'total'    =>  0,
                'totalNotFiltered' => 0,
                'rows'      =>  config('app.url_be')."api/communicationinitiative/$type$query"
            ],200);*/

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
}
