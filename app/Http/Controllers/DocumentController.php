<?php

namespace App\Http\Controllers;

use App\document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(document $document)
    {
        //
    }

    public function downloadFile(Request $request) {
        $source = $request->get('source');
        $fileName = $request->get('file_name');
        $token = session()->get('token');

        if(File::exists(public_path("storage/".$source))){
            $headers = array(
                "Authorization" => "Bearer $token",
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/zip',
                'Content-Length' => filesize(public_path("storage/" . $source)),
            );

            return response()->download(public_path("storage/" . $source), $fileName, $headers);
        } else {
            session()->flash('error',"Document tidak ditemukan");
            return back();
        }
    }

    public function download_content($id) {
        try {
            $token = session()->get('token');
            $ch = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . "api/download/attach/content/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);
            // return response()->json($hasil);
//            dd($hasil);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {

                    $data = $hasil->data;
                    $files = $data->attach_file;
                    $zip = new ZipArchive;
                    $fileName = 'attach_download.zip';
                    $fileNameDownload = "attach_".$data->type_file."-".\Str::slug($data->title)."-".now()->timestamp.".zip";

                    if ($zip->open(public_path("storage/" . $fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                        foreach ($files as $key => $value) {
                            $relativeNameInZipFile = basename($value->tipe . "-" . $value->nama);
                            $zip->addFile(public_path('storage/' . $value->url_file), $relativeNameInZipFile);
                        }

                        $zip->close();
                    }

                    $headers = array(
                        "Authorization" => "Bearer $token",
                        'Content-Description' => 'File Transfer',
                        'Content-Type' => 'application/zip',
                        'Content-Length' => filesize(public_path("storage/" . $fileName)),
                    );

                    return response()->download(public_path("storage/" . $fileName), $fileNameDownload, $headers)->deleteFileAfterSend(true);
                }else{
                    session()->flash('error',"Something Error, Try Again Please");
                    return back();
                }
            }else{
                session()->flash('error',"Something Error, Try Again Please");
                return back();
            }

        } catch (\Throwable $th) {
            session()->flash('error', "Something Error, Try Again Please");
            return back();
        }
    }

    public function download_implementation($id) {
        try {
            $token = session()->get('token');
            $ch = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . "api/download/attach/implementation/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);
            // return response()->json($hasil);
//            dd($hasil);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {

                    $data = $hasil->data;
//                    $files = $data->attach_file;
                    $zipFiles = array();
                    $zip = new ZipArchive;
                    $fileName = 'attach_download.zip';
                    $fileNamePilot = 'attach_piloting.zip';
                    $fileNameRoll = 'attach_rollout.zip';
                    $fileNameSos = 'attach_sosialisasi.zip';
                    $fileNameDownload = "attach_implementation-".\Str::slug($data->title)."-".now()->timestamp.".zip";

                    if (count($data->piloting) > 0) {
                        if ($zip->open(public_path("storage/" . $fileNamePilot), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                            foreach ($data->piloting as $key => $value) {
                                $relativeNameInZipFile = basename($value->tipe . "-" . $value->nama);
                                $zip->addFile(public_path('storage/' . $value->url_file), $relativeNameInZipFile);
                            }

                            $zip->close();
                        }
                        $zipFiles[] = $fileNamePilot;
                    }

                    if (count($data->rollout) > 0) {
                        if ($zip->open(public_path("storage/" . $fileNameRoll), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                            foreach ($data->rollout as $key => $value) {
                                $relativeNameInZipFile = basename($value->tipe . "-" . $value->nama);
                                $zip->addFile(public_path('storage/' . $value->url_file), $relativeNameInZipFile);
                            }

                            $zip->close();
                        }
                        $zipFiles[] = $fileNameRoll;
                    }

                    if (count($data->sosialisasi) > 0) {
                        if ($zip->open(public_path("storage/" . $fileNameSos), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                            foreach ($data->sosialisasi as $key => $value) {
                                $relativeNameInZipFile = basename($value->tipe . "-" . $value->nama);
                                $zip->addFile(public_path('storage/' . $value->url_file), $relativeNameInZipFile);
                            }

                            $zip->close();
                        }
                        $zipFiles[] = $fileNameSos;
                    }


                    if ($zip->open(public_path("storage/" . $fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                        foreach ($zipFiles as $key => $value) {
                            $relativeNameInZipFile = basename($value);
                            $zip->addFile(public_path('storage/' . $value), $relativeNameInZipFile);
                        }

                        $zip->close();
                    }

                    foreach ($zipFiles as $value) {
                        File::delete(public_path("storage/".$value));
                    }

                    $headers = array(
                        "Authorization" => "Bearer $token",
                        'Content-Description' => 'File Transfer',
                        'Content-Type' => 'application/zip',
                        'Content-Length' => filesize(public_path("storage/" . $fileName)),
                    );

                    return response()->download(public_path("storage/" . $fileName), $fileNameDownload, $headers)->deleteFileAfterSend(true);
                }else{
                    session()->flash('error',"Something Error, Try Again Please");
                    return back();
                }
            }else{
                session()->flash('error',"Something Error, Try Again Please");
                return back();
            }

        } catch (\Throwable $th) {
            session()->flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function download_attach_project($id) {
        try {
            $token = session()->get('token');
            $ch = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . "api/download/file/project/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);
            // return response()->json($hasil);
//            dd($hasil);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {

                    $data = $hasil->data;
                    $files = $data->document;
                    $zip = new ZipArchive;
                    $fileName = 'attach_project.zip';
                    $fileNameDownload = "attach_project-".\Str::slug($data->nama)."-".now()->timestamp.".zip";

                    if ($zip->open(public_path("storage/" . $fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                        foreach ($files as $key => $value) {
                            $relativeNameInZipFile = basename($value->nama);
                            $zip->addFile(public_path('storage/' . $value->url_file), $relativeNameInZipFile);
                        }

                        $zip->close();
                    }

                    $headers = array(
                        "Authorization" => "Bearer $token",
                        'Content-Description' => 'File Transfer',
                        'Content-Type' => 'application/zip',
                        'Content-Length' => filesize(public_path("storage/" . $fileName)),
                    );

                    return response()->download(public_path("storage/" . $fileName), $fileNameDownload, $headers)->deleteFileAfterSend(true);
                }else{
                    session()->flash('error',"Something Error, Try Again Please");
                    return back();
                }
            }else{
                session()->flash('error',"Something Error, Try Again Please");
                return back();
            }

        } catch (\Throwable $th) {
            session()->flash('error', "Something Error, Try Again Please");
            return back();
        }
    }
}
