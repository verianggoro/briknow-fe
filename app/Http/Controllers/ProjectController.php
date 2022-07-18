<?php

namespace App\Http\Controllers;

use App\project;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ProjectController extends Controller
{
    public $token_auth;
    public $data;
    public $tgl_mulai;
    public $tgl_selesai;
    public $is_allowed;
    public $is_favorit;

    public function index($slug)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/project/'.$slug);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    if ($hasil->data->data->flag_mcs == 5) {
                        $this->data = $hasil->data->data;
                        $this->tgl_mulai = $hasil->data->tgl_mulai;
                        $this->tgl_selesai = $hasil->data->tgl_selesai;
                        $this->is_allowed = $hasil->data->is_allowed;
                        $this->is_favorit = $hasil->data->is_favorit;
                        $data = $this->data;
                        $tgl_mulai = $this->tgl_mulai;
                        $tgl_selesai = $this->tgl_selesai;
                        $is_allowed = $this->is_allowed;
                        $is_favorit = $this->is_favorit;
    
                        return view('project', compact(['data', 'tgl_mulai', 'tgl_selesai', 'is_allowed', 'is_favorit']));
                    }else{
                        session()->flash('error','Project Belum Terpublish');
                        return redirect()->back();
                    }
                }else{
                    session()->flash('error',$hasil->data->message);
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

    public function doc_project($kunci = "",$search="*",$sort = "desc"){
        try {
            $search = str_replace(' ', '_', $search);

            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/document_proj/".$kunci."/".$search."/".$sort);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if ($hasil->status == 1) {
                $data   = $hasil->data;
            }else{
                $data   = [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        $view = view('project.document',compact('data'))->render();
        $view_preview = view('project.preview',compact('data'))->render();
        return response()->json([
            'html'=>$view,
            'preview'=>$view_preview,
        ]);
    }
    
    public function archive(Request $request){
        if($request->has('data')) {
            try {
                $tampung = request()->data;
                $zipFileName = 'download.zip';

                // destination
                $path_zip = public_path('temp_download/'.session()->get('personal_number').'/ex');
                FacadesFile::deleteDirectory($path_zip);
                FacadesFile::makeDirectory($path_zip, 777, true, true);
                
                // temp
                chdir( sys_get_temp_dir() ); // Zip always get's created in current working dir so move to tmp.
                $zip = new ZipArchive;
                $tmp_zipname = 'download_lampiran.zip'; // Generate a temp UID for the file on disk.
                // $zipname = 'package_name.zip'; // True filename used when serving to user.
                if ( true === $zip->open( $tmp_zipname, ZipArchive::CREATE ) ) {
                    // $zip->addFromString( 'file_name.txt', 'asdasdasddsasd' );
                    for ($i=0; $i < count($tampung); $i++) { 
                        $file = storage_path("app/public/".$tampung[$i]);
                        $relativename = basename($file);
                        $zip->addFile($file, $relativename);
                    }
                    $zip->close();

                    // permission
                    chmod(sys_get_temp_dir(). '/' .$tmp_zipname, 0777);
                    chmod(public_path('temp_download/'.session()->get('personal_number').'/ex'), 0777);
                    
                    // move to folder public
                    copy(
                        sys_get_temp_dir(). '/' .$tmp_zipname, 
                        public_path('temp_download/'.session()->get('personal_number').'/ex/'.$zipFileName));
                    
                    // tutup
                    chmod(public_path('temp_download/'.session()->get('personal_number').'/ex'), 0755);
                    unlink( sys_get_temp_dir(). '/' .$tmp_zipname );

                    $data   = config('app.url').'temp_download/'.session()->get('personal_number').'/ex'."/".$zipFileName;
                }else{
                    $data   = false;
                }

                return response()->json($data);
            } catch (\Throwable $th) {
                $data   = false;
                return response()->json($data);
            }
        }
    }
}
