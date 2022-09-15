<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommunicationController extends Controller
{
    public function index()
    {
        return redirect('mycomsupport/initiative');
    }

    public function communicationInitiativePublic()
    {
        return redirect('mycomsupport/initiative/article');
    }

    public function comInitTypePublic($type)
    {
        $type_list = (object) array(
            array("id" => "article", "name" => "Articles", "path" => "mycomsupport/initiative/article"),
            array("id" => "logo", "name" => "Icon, Logo, Maskot BRIVO", "path" => "mycomsupport/initiative/logo"),
            array("id" => "infographics", "name" => "Infographics", "path" => "mycomsupport/initiative/infographics"),
            array("id" => "transformation", "name" => "Transformation Journey", "path" => "mycomsupport/initiative/transformation"),
            array("id" => "podcast", "name" => "Podcast", "path" => "mycomsupport/initiative/podcast"),
            array("id" => "video", "name" => "Video Content", "path" => "mycomsupport/initiative/video"),
            array("id" => "instagram", "name" => "Instagram Content", "path" => "mycomsupport/initiative/instagram"),
        );
        $type_array = array("article", "logo", "infographics", "transformation", "podcast", "video", "instagram");
        if (!in_array($type, $type_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('communication_initiative', compact(['type', 'type_list', 'sync_es', 'token_auth']));
    }

    // page public strategic initiative
    public function strategicInit(){
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('strategic_initiative', compact(['sync_es', 'token_auth']));
    }

    // page public implementation
    public function implementationInit(){
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('implementation', compact(['sync_es', 'token_auth']));
    }

}
