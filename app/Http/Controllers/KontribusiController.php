<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
// use File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class KontribusiController extends Controller
{
    public function index()
    {
        // if (session()->get('role') <> 0 && session()->get('role') <> 3) {
        //     return back();
        // }
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/prepare_form");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            // dd($hasil);
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

        return view('kontribusi',compact(['data', 'tgl_mulai']));
    }

    public function validasikontribusi(){
        request()->validate([
                'photo'         => "required",
                'direktorat'    => "required",
                'divisi'        => 'required',
                'nama_project'  => 'required',
                'status'        => 'required',
                'tgl_mulai'     => 'required',
                'pm'            => 'required',
                'emailpm'       => 'required',
                'jenispekerja'  => 'required',
                'restricted'    => 'required',
                'deskripsi'     => 'required',
                'metodologi'    => 'required',
                'keyword'       => 'required',
                'restricted'    => 'required',
                'attach'        => 'required',
                'checker'       => 'required',
                'signer'        => 'required',
            ]);
    }

    public function getDivisi($direktorat)
    {
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            $direktorat = str_replace(' ', '-', $direktorat);
            // return response()->json($direktorat);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/divisibydirektorat/".$direktorat);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data->data;
                }else{
                    $data   = [];
                }
            }else{
                $data  =  [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }
        return response()->json([
            'data'  =>  $data
        ]);
    }

    public function getuser(){
        try {
            $data       = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/getuser");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data->data;
                }else{
                    $data   = [];
                }
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        return response()->json([
            'data'=>$data,
        ]);
    }

    public function create(){
        // VALIDASI
        request()->validate([
            'photo'         => "required",
            'direktorat'    => "required",
            'divisi'        => 'required',
            'nama_project'  => 'required',
            'tgl_mulai'     => 'required',
            'pm'            => 'required',
            'emailpm'       => 'required',
            'jenispekerja'  => 'required',
            'restricted'    => 'required',
            'deskripsi'     => 'required',
            'metodologi'    => 'required',
            'keyword'       => 'required',
            'restricted'    => 'required',
            'attach'        => 'required',
            'checker'       => 'required',
            'signer'        => 'required',
        ]);

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

        if (request()->jenispekerja == 1) {
            request()->validate([
                'konsultant'    => 'required',
            ]);
            $konsultant     = request()->konsultant;
        }else{
            $konsultant     = 'internal';
        }
        // dd($konsultant);
        if (request()->restricted == 1) {
            request()->validate([
                'user'          => 'required',
            ]);
            $user           = request()->user;
        }else{
            $user           = '-';
        }

        if (request()->project == 1) {
            if (session()->get('role') == 3) {
                $mode = 5;
            }else{
                $mode = request()->project;
            }
        }else{
            if (session()->get('role') == 3) {
                $mode = 4;
            }else{
                $mode = request()->project;
            }
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
                'photo'         => request()->photo,
                'direktorat'    => request()->direktorat,
                'divisi'        => request()->divisi,
                'nama_project'  => request()->nama_project,
                'status'        => $status,
                'tgl_mulai'     => request()->tgl_mulai,
                'tgl_selesai'   => $tgl_selesai,
                'pm'            => request()->pm,
                'emailpm'       => request()->emailpm,
                'jenispekerja'  => request()->jenispekerja,
                'konsultant'    => $konsultant,
                'restricted'    => request()->restricted,
                'deskripsi'     => request()->deskripsi,
                'metodologi'    => request()->metodologi,
                'keyword'       => request()->keyword,
                'restricted'    => request()->restricted,
                'lesson'            => request()->lesson,
                'lesson_keterangan' => request()->lesson_keterangan,
                'user'          => $user,
                'attach'        => request()->attach,
                'checker'       => request()->checker,
                'signer'        => request()->signer,
                'token_bri'     => session()->get('token_bri'),
                'mode'          => $mode,
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

    public function edit($slug){
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/prepare_form/".$slug);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    if ($hasil->data->data <> []) {
                        $data   = $hasil->data;
                    }else{
                        return back();
                    }
                }else{
                    return back();
                }
            }else{
                return back();
            }
        }catch (\Throwable $th) {
            return back();
        }

        return view('kontribusi',compact('data'));
    }

    public function update(){
        // VALIDASI
        // dd()
        request()->validate([
            'id'        => "required",
            'photo'         => "required",
            'direktorat'    => "required",
            'divisi'        => 'required',
            'nama_project'  => 'required',
            'tgl_mulai'     => 'required',
            'pm'            => 'required',
            'emailpm'       => 'required',
            'jenispekerja'  => 'required',
            'restricted'    => 'required',
            'deskripsi'     => 'required',
            'metodologi'    => 'required',
            'keyword'       => 'required',
            'restricted'    => 'required',
            'attach'        => 'required',
            'checker'       => 'required',
            'signer'        => 'required',
        ]);

        // id
        $id = request()->id;

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

        if (request()->jenispekerja == 1) {
            request()->validate([
                'konsultant'    => 'required',
            ]);
            $konsultant     = request()->konsultant;
        }else{
            $konsultant     = 'internal';
        }
        // dd($konsultant);

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
                'photo'         => request()->photo,
                'direktorat'    => request()->direktorat,
                'divisi'        => request()->divisi,
                'nama_project'  => request()->nama_project,
                'status'        => $status,
                'tgl_mulai'     => request()->tgl_mulai,
                'tgl_selesai'   => $tgl_selesai,
                'pm'            => request()->pm,
                'emailpm'       => request()->emailpm,
                'jenispekerja'  => request()->jenispekerja,
                'konsultant'    => $konsultant,
                'restricted'    => request()->restricted,
                'deskripsi'     => request()->deskripsi,
                'metodologi'    => request()->metodologi,
                'keyword'       => request()->keyword,
                'restricted'    => request()->restricted,
                'user'          => $user,
                'lesson'            => request()->lesson,
                'lesson_keterangan' => request()->lesson_keterangan,
                'attach'        => request()->attach,
                'checker'       => request()->checker,
                'signer'        => request()->signer,
                'token_bri'     => session()->get('token_bri'),
                'mode'          => request()->project,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/kontribusi/update/'.$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                Session::flash('success','Perubahan berhasil disimpan');
                return redirect('/myproject');
            }else{
                Session::flash('error',$hasil->data->message);
                return redirect('/myproject');
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    Session::flash('error',$hasil->data->message);
                    return redirect('/login');
                }
            }
            Session::flash('error', "Something Error, Try Again Please");
            return redirect('/myproject');
        }
    }

    public function appr($id){
        // id
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'id'         => $id,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/kontribusi/appr');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // return response()->json($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        'status'    =>  1,
                        'message'   =>  'Berhasil menyetujui Proyek.'
                    ]);
                }else{
                    if (isset($hasil->data->error_code)) {
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }else{
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  'Gagal menyetujui Proyek!'
                ]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Gagal menyetujui Proyek!'
            ]);
        }
    }

    public function hapus($id){
        // id
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'id'         => $id,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/kontribusi/hapus');
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
                    return response()->json([
                        'status'    =>  1,
                        'message'   =>  'Berhasil menghapus Proyek.'
                    ]);
                }else{
                    if (isset($hasil->data->error_code)) {
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }else{
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  'Gagal menghapus Proyek!'
                ]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Gagal menghapus Proyek!'
            ]);
        }
    }

    public function send($id){
        // id
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'id'         => $id,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/kontribusi/send');
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
                    return response()->json([
                        'status'    =>  1,
                        'message'   =>  'Berhasil mengirim Proyek.'
                    ]);
                }else{
                    if (isset($hasil->data->error_code)) {
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }else{
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  'Gagal mengirim Proyek!'
                ]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Gagal mengirim Proyek!'
            ]);
        }
    }

    public function reject($id){
        // id
        // dd(request()->all());
        $note = "";
        foreach (request()->all() as $key => $val) {
            $note = $key;
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
                'id'         => $id,
                'note'       => str_replace('_', ' ', $note), //Karena dari SweetAlert2 TextArea hasilnya ada _
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/kontribusi/reject');
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
                    return response()->json([
                        'status'    =>  1,
                        'message'   =>  'Berhasil menolak Proyek.'
                    ]);
                }else{
                    if (isset($hasil->data->error_code)) {
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }else{
                        return response()->json([
                            'status'    =>  0,
                            'message'   =>  $hasil->data->message
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  'Gagal menolak Proyek!'
                ]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Gagal menolak Proyek!'
            ]);
        }
    }

    // sudah
    public function uploadphoto($kategori){
        try {
            $this->token_auth = session()->get('token');
            $file = request()->file($kategori);
            $filename = $file->getClientOriginalName();
            $filesize = $file->getSize();
            $extension= \File::extension($filename);
            $folder = uniqid().'-'.now()->timestamp;
            $objek_diupload = $file->store('document/'.$kategori.'/'.$folder, 'public');

            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            // dd(request()->file($kategori));
            $post_data = array(
                'file'          => request()->file($kategori),
                'filename'      => $filename,
                'filesize'      => $filesize,
                'extension'     => $extension,
                'path'          => $objek_diupload,
                'dir'           => 'document/'.$kategori.'/'.$folder,
            );

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/up/$kategori");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json(['request' => $result]);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return $hasil->data; 
                }else{
                    return 0;
                }
            }else{
                return 0;
            }

        } catch (\Throwable $th) {
            return $th;
        }
    }

    // sudah
    public function delete($kategori){
        try {
            $this->token_auth = session()->get('token');
            $path = request()->file($kategori);
            if(File::exists(public_path($path))){
                File::delete(public_path($path));
            }

            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            // dd(request()->file($kategori));
            $post_data = array(
                'file'          => request()->file($kategori),
                'path'          => $path,
            );

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/up/$kategori");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            return response()->json(['request' => $post_data]);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return $hasil->data; 
                }else{
                    return 0;
                }
            }else{
                return 0;
            }

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function upimgcontent(){
        if (request()->hasFile('upload')) {
            $originName = request()->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = request()->file('upload')->getClientOriginalExtension();
            $fileName = $fileName."_".time().".".$extension;

            request()->file('upload')->move(public_path('storage/content'), $fileName);

            $CKEditorFuncNum = request()->input('CKEditorFuncNum');
            $url = asset('storage/content/'.$fileName);
            $msg = 'Image Uploaded Successfully';

            return response()->json([
                'uploaded' => '1',
                'fileName' => $fileName,
                'url' => $url
            ]);
        }
    }
}