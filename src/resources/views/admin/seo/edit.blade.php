@extends('admin.layouts.master')

@push('style-include')
  <link rel="stylesheet" href="{{asset('assets/global/css/summnernote.css')}}">
@endpush
@section('content')

<div class="row g-4 mb-4">

   @php
        $localeArray = $languages->pluck('code')->toArray();
        $appLanguage = session()->get("locale");
        usort($localeArray, function ($a, $b) {
            $systemLocale = session()->get("locale");
            $systemLocaleIndex = array_search($systemLocale, [$a, $b]);

            return $systemLocaleIndex === false ? 0 : ($systemLocaleIndex === 0 ? -1 : 1);
        });
   @endphp


    <form action="{{route('admin.seo.update')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <input hidden type="text" id="id" name="id" value="{{$seo->id}}">
        <input hidden type="text" id="id" name="identifier" value="{{$seo->identifier}}">

        <div class="i-card-md">
            <div class="card--header">
                <h4 class="card-title">
                    {{translate('Basic Information')}}
                </h4>
            </div>
        
            <div class="card-body">
                <div class="row">                         
                    <div class="col-lg-{{$seo->identifier == 'home' ?"6" :"12"}}">
                        <ul class="nav nav-tabs style-1" role="tablist">                               
                            @foreach($localeArray as $code)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link  
                                    {{$loop->index == 0 ? "active" :""}}
                                    " id="lang-tab-{{$code}}" data-bs-toggle="pill" data-bs-target="#lang-tab-content-{{$code}}" type="button" role="tab" aria-controls="lang-tab-content-{{$code}}" aria-selected="true">
                                        <img class="lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{$code}}" class="me-2 rounded" height="18">
                                        <span class="align-middle">
                                            {{$code}} 	
                                            
                                            @if(session()->get("locale") == strtolower($code))
                                            <span class="text-danger d-inline-block nowrap" >*</span>
                                            @endif
                                        </span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div id="titleTab" class="tab-content">
                            @foreach($localeArray as $code)
                                <div class="tab-pane fade {{$loop->index == 0 ? " show active" :""}} " id="lang-tab-content-{{$code}}" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-inner">
                                                <label for="{{$code}}-input">
                                                    {{translate('Title')}} ({{$code}})
                                                    @if(session()->get("locale") == strtolower($code))
                                                    <small class="text-danger">*</small>
                                                    @endif
                                                </label>
                                                @php
                                                    $lang_code =  strtolower($code)
                                                @endphp

                                                <input type="text" name="title[{{strtolower($code)}}]"   placeholder="{{translate("Enter Title")}}"
                                                    value="{{@$seo->title->$lang_code}}"
                                                {{session()->get("locale") == strtolower($code) ? "required" :""}}>
            
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>

                    @php
                       $ignoreIdetifier = [
                            'home',
                            'login',
                            'register',
                            'verification',
                        ];
                    @endphp


                    @if(!in_array($seo->identifier,$ignoreIdetifier))
                        <div class="col-lg-12">                                     
                            <div class="form-inner">
                                <label class="form-label" for="slug">
                                    {{translate('Url Slug')}} 
                                    <small class="text-danger">*</small>
                                </label>                                      
                                <input required type="text" name="slug" placeholder="{{translate("Enter Slug")}}"
                                    value="{{@$seo->slug}}">

                            </div>
                        </div>
                    @endif

                    <div class="col-lg-{{$seo->identifier == 'home' ?"6" :"12"}}">
                        <ul class="nav nav-tabs style-1" role="tablist">
                            
                            @foreach($localeArray as $code)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link  
                                    {{$loop->index == 0 ? "active" :""}}
                                    " id="lang-content-{{$code}}" data-bs-toggle="pill" data-bs-target="#lang-metaTitle-content-{{$code}}" type="button" role="tab" aria-controls="lang-metaTitle-content-{{$code}}" aria-selected="true">
                                        <img class="lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{$code}}" class="me-2 rounded" height="18">
                                        <span class="align-middle">
                                            {{$code}} 	
                                          
                                        </span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div id="metaTileTab" class="tab-content">

                            @foreach($localeArray as $code)
                                <div class="tab-pane fade {{$loop->index == 0 ? " show active" :""}} " id="lang-metaTitle-content-{{$code}}" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 form-inner">
                                            <div class="mb-3">
                                                <label class="form-label" for="{{$code}}-input">
                                                    {{translate('Meta Title')}} ({{$code}})
                                                  
                                                </label>
                                                @php
                                                    $lang_code =  strtolower($code)
                                                @endphp

                                                <input type="text" name="meta_title[{{strtolower($code)}}]"   placeholder="{{translate("Enter Title")}}"
                                                    value="{{ @$seo->meta_title->$lang_code}}">
            
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>


                    <div class="col-12">
                        <ul class="nav nav-tabs style-1" role="tablist">                                      
                            @foreach($localeArray as $code)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link  
                                    {{$loop->index == 0 ? "active" :""}}
                                    " id="lang-content-{{$code}}" data-bs-toggle="pill" data-bs-target="#lang-metaDes-content-{{$code}}" type="button" role="tab" aria-controls="lang-metaDes-content-{{$code}}" aria-selected="true">
                                        <img class="lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{$code}}" class="me-2 rounded" height="18">
                                        <span class="align-middle">
                                            {{$code}} 	
                                            
                                        </span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div id="metaDesTab" class="tab-content">
                            
                            @foreach($localeArray as $code)
                                <div class="tab-pane fade {{$loop->index == 0 ? " show active" :""}} " id="lang-metaDes-content-{{$code}}" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12 ">
                                            <div class="form-inner">
                                                <label class="form-label" for="{{$code}}-input">
                                                    {{translate('Meta Description')}} ({{$code}})
                                                  
                                                </label>
                                                @php
                                                    $lang_code =  strtolower($code)
                                                @endphp

                                                <textarea  placeholder="{{translate("Enter Description")}}"  name="meta_description[{{strtolower($code)}}]" id="" cols="30" rows="5">{{@$seo->meta_description->$lang_code}}</textarea>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                
                    <div class="col-12">
                        <div class="form-inner">
                            <label for="page"> 
                                {{translate('Meta Keywords')}}  
                            </label>
                            <select name="meta_keywords[]" multiple  class="selectMeta" id="">
                                @if($seo->meta_keywords)
                                    @foreach($seo->meta_keywords as $key)
                                        <option selected value="{{$key}}">{{$key}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-12 ">
                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
        
   </form>

</div>


@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";
            $(".selectMeta").select2({
                placeholder:"{{translate('Enter Keywords')}}",
                tags: true,
                tokenSeparators: [',']
	     	})
	})(jQuery);
</script>
@endpush
