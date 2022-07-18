@forelse ($data as $post)
    @if(!empty($post->content))
        @php
        $judul = Str::limit($post->judul, 50);
        $c = strip_tags($post->content);
        $content = Str::limit($c, 50);
        @endphp
    @endif
    <div class="col-lg-12">
        <div class="card rounded mb-3 card-forum">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-md-3 col-sm-12 mb-2 thumb-sm">
                        <div class="p-0 w-100">
                            <div class="d-flex thumb-forum align-items-center">
                                <img src="{{asset_app('assets/img/default-forum.svg')}}" width="120%" class="card-img-left border-0 rounded thumb h-100">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12 d-flex align-items-center">
                        <div class="w-100 pl-1 content-myforum">
                            <div class="card-body content-project"> 
                                <div class="row mb-3 mx-0 prof-lg">
                                    <div class="d-flex align-items-center">
                                        <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" width="22px" class="rounded-circle mr-1">
                                        <small class="font-weight-bolder d-flex align-items-center">{{$post->user->name}}</small>
                                        <small class="text-secondary d-flex align-items-center mx-1">
                                            {{\Carbon\carbon::create($post->updated_at)->diffForHumans()}}
                                            @if ($post->restriction == '1')
                                                <svg class="w-6 h-6 mx-1 mb-1" width="12px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                            @else
                                                <svg class="w-6 h-6 mx-1 mb-1" width="12px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3 mx-0 prof-sm">
                                    <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" width="35px" class="rounded-circle mr-1">
                                    <div class="w-75">
                                        <small class="d-block font-weight-bolder">{{$post->user->name}}</small>
                                        <small class="d-flex text-secondary">
                                            {{\Carbon\carbon::create($post->updated_at)->diffForHumans()}}
                                            @if ($post->restriction == '1')
                                                <svg class="w-6 h-6 mx-1 mb-1" width="12px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                            @else
                                                <svg class="w-6 h-6 mx-1 mb-1" width="12px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div id="mid">
                                    <a href="{{url()->current()."/".$post->slug}}" style="text-decoration: none; color: inherit;">
                                        <h4 class="d-block text-dark font-weight-bolder lh-1 mb-3" {!!strlen($post->judul) > 46 ? "data-toggle='tooltip' data-placement='top' title='$post->judul'" : ""!!}>{{\Str::limit($judul,50)}}</h4>
                                        <span class="d-block mb-4">{!!\Str::limit(strip_tags($post->content),120)!!}</span>
                                    </a>
                                    <div>
                                        <button class="btn btn-white p-1">
                                            <svg class="w-6 h-6 mx-1 mb-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg> {{count($post->forumcomment)}} Comments
                                        </button>
                                        <button class="btn btn-white p-1" type="button" onclick="kopas('{{!empty($post->judul)?$post->judul:'-'}} di BRIKNOW. &nbsp;{{URL::current()}}/{{$post->slug}}');">
                                            <svg class="w-6 h-6 mx-1 mb-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg> Share
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-2 thumb-lg">
                        <a href="{{url()->current()."/".$post->slug}}" style="text-decoration: none;">
                            <div class="p-0 d-flex align-items-center thumb-forum h-100 w-100">
                                <img src="{{asset_app('assets/img/default-forum.png')}}" width="120%" class="card-img-left border-0 rounded thumb h-100">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-md-12 d-flex justify-content-center mt-5">
        <img src="{{asset_app('assets/img/empty-forum.png')}}" class="w-50" draggable="false" alt="">
    </div>
@endforelse