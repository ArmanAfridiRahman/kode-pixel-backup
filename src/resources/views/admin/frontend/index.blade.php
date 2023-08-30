@extends('admin.layouts.master')
@section('content')

    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Frontend Section List')}}</h4>
        </div>

        <div class="card-body">            			
            <div class="faq-wrap">
                <div class="accordion" id="accordionExample">
                    @forelse($frontends as $frontend)
                        <form class="search-sections" enctype="multipart/form-data" method="post" action="{{route("admin.frontend.update")}}" >
                            @csrf
                            <input hidden type="id" name="id" value="{{$frontend->id}}">
                            <div class="accordion-item">
                                    <h2 class="accordion-header" id="accHead-{{$frontend->id}}">
                                        <button class="accordion-button {{$loop->index !=0 ? "collapsed" :""}} " type="button" data-bs-toggle="collapse" data-bs-target="#collap-{{$frontend->id}}" aria-expanded="false" aria-controls="collap-{{$frontend->id}}">
                                            {{$frontend->name}}
                                        </button>
                                    </h2>
                                    <div id="collap-{{$frontend->id}}" class="accordion-collapse collapse {{$loop->index == 0 ? "show" :"" }} " aria-labelledby="accHead-{{$frontend->id}}" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <h5 class="mb-0 fs-14">
                                                @if($frontend->slug == 'social_section')
                                                    <a target="blank" href="https://fontawesome.com/search">
                                                        <span class="i-badge capsuled info">
                                                            {{translate('See Icon')}}
                                                        </span>
                                                    </a>
    
                                                @endif
                                            </h5>
                                            @php

                                                $frontendSection = $frontend->value;

                                            @endphp

                                            <div class="row">
                                                @foreach($frontendSection as $secton_key=> $elements)
                                                    @foreach( $elements as $keys=>$section_data)
                                                        @foreach( $section_data as $key=> $data)                                     
                                                            @if($key == 'value')
                                                                <div class="col-12">   
                                                                    <div class="form-inner">
                                                                        <label for="frontend-section">
                                                                            {{@translate(ucfirst(str_replace("_"," ",$keys)))}} 
                                                                            @if($section_data->type == 'file') 
                                                                                <small class="text-danger" >({{$section_data->size}})</small>
                                                                                @else
                                                                                <small class="text-danger" > {{($keys =='position' ? "(after)" : "") }} *</small>
                                                                            @endif
                                                                        </label>

                                                                        @if($section_data->type == 'textarea')
                                                                           <textarea required placeholder="{{translate("Type Here...")}}"  name="frontend[{{$secton_key}}][{{ $keys}}][{{$key}}]" id="" cols="30" rows="5">{{$section_data->value}}</textarea>
                                                                        @else
                                                                           <input placeholder="{{translate("Type Here")}} ... " @if($section_data->type !='file') required @endif name="frontend[{{ $secton_key}}][{{ $keys}}][{{$key}}]" type="{{$section_data->type}}" value="{{$section_data->value}}" id="frontend-section" >
                                                                        @endif
                                                                    </div>       
            
                                                                    @if($section_data->type == 'file')
                                                                        <div class="mt-2 preview-image">
                                                                            <img class=""  src="{{imageUrl(config("settings")['file_path']['frontend']['path']."/".@$frontend->file->name ,@$frontend->file->disk ) }}" alt="{{@$frontend->file->name}}">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                @if($key  == 'url' || $key  == 'icon' || $key  == 'sub_title' || $key  == 'title'   )
                                                                    <div class="col-md-6">
                                                                        <div class="form-inner">
                                                                            <label for="frontend-section" class="form-label">
                                                                                {{ucfirst(str_replace("_"," ",$keys))}}	({{ucfirst(str_replace("_"," ",$key))}})
                                                                                    <small class="text-danger" >*</small>
                                                                            </label>
                                                                            <input required name="frontend[{{ $secton_key}}][{{ $keys}}][{{$key}}]" type="text" value="{{$section_data->$key}}" placeholder="{{translate("Name")}}">
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <input hidden name="frontend[{{ $secton_key}}][{{ $keys}}][{{$key}}]" type="text"   value="{{$section_data->$key}}" placeholder="{{translate("Name")}}">
                                                                @endif
                                                                @endif
                                                        @endforeach
                                                        @endforeach
                                                @endforeach

                                                <div class="col-12">
                                                    <div class="form-inner">
                                                        <label for="status">
                                                                {{translate('Status')}}  <small class="text-danger" >*</small>
                                                        </label>

                                                        <select name="status" id="" class="select2">
                                                            @foreach( App\Enums\StatusEnum::toArray() as $key => $val)
                                                                <option {{$frontend->status ==  $val ? 'selected' :""}}  value="{{$val}}">
                                                                    {{$key}}
                                                                </option>
                                                            @endforeach
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
                            </div>
                        </form>
                    @empty
                       @include('admin.partials.not_found')
                    @endforelse
                </div>
            </div>				
        </div>
    </div>

@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";
            $(".select2").select2({
			   placeholder:"{{translate('Select Status')}}",
	     	})
	})(jQuery);
</script>
@endpush


