@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/summnernote.css')}}">
@endpush
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{'Frontend Section List'}}</h4>
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
                                                            {{'See Icon'}}
                                                        </span>
                                                    </a>

                                                @endif
                                            </h5>
                                            @php
                                                $frontendSection = $frontend->value;
                                            @endphp

                                            <div class="row">
                                                @foreach($frontendSection as $section_key=> $elements)
                                                    @foreach( $elements as $keys=>$section_data)
                                                        @foreach( $section_data as $key=> $data)
                                                            @if($key == 'value')
                                                                <div class="col-12">
                                                                    <div class="form-inner">
                                                                        <label for="frontend-section">
                                                                            {{ucfirst(str_replace("_"," ",$keys))}}
                                                                            @if($section_data->type == 'file')
                                                                                <small class="text-danger" >({{$section_data->size}})</small>
                                                                                @else
                                                                                <small class="text-danger" > {{($keys =='position' ? "(after)" : "") }} *</small>
                                                                            @endif
                                                                        </label>

                                                                        @if($section_data->type == 'textarea')
                                                                            <textarea required placeholder="{{"Type Here..."}}"  name="frontend[{{$section_key}}][{{$keys}}][{{$key}}]" id="" cols="30" rows="5">{{$section_data->value}}</textarea>
                                                                        @elseif($section_data->type == 'textEditor')
                                                                            <textarea required placeholder="{{"Type Here..."}}" class="summernote" name="frontend[{{$section_key}}][{{$keys}}][{{$key}}]" id="" cols="30" rows="5">{{$section_data->value}}</textarea>
                                                                        @elseif($section_data->type == 'status')
                                                                            <div class="col-12">
                                                                                <div class="form-inner">
                                                                                    <select name="frontend[{{$section_key}}][{{$keys}}][{{$key}}]" id="" class="select2">
                                                                                        @foreach( App\Enums\StatusEnum::toArray() as $btn_key => $val)
                                                                                            <option {{$section_data->value == $val ? 'selected' :""}}  value="{{$val}}">
                                                                                                {{$btn_key}}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                        
                                                                            @if($section_key == 'dynamic_element')
                                                                                
                                                                                <div class="col-12">
                                                                                    <div class="form-inner">
                                                                                        <a href="javascript:void(0)" class="i-btn btn--sm btn--success" id="addNew"><i class="las la-plus me-1"></i>Add A Market Place</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="addedField form-inner">
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <input placeholder="{{"Type Here"}} ... " @if($section_data->type !='file') required @endif name="frontend[{{$section_key}}][{{$keys}}][{{$key}}]" type="{{$section_data->type}}" value="{{$section_data->value}}" id="frontend-section" >
                                                                            @endif

                                                                        @endif
                                                                    </div>

                                                                    @if($section_data->type == 'file' && $section_key != 'dynamic_element')
                                                                        <div class="mt-2 preview-image">
                                                                            <img class="mb-4"  src="{{imageUrl(config("settings")['file_path']['frontend']['path']."/".@$frontend->file->name ,@$frontend->file->disk ) }}" alt="{{@$frontend->file->name}}">
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
                                                                            <input required name="frontend[{{ $section_key}}][{{ $keys}}][{{$key}}]" type="text" value="{{$section_data->$key}}" placeholder="{{"Name"}}">
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <input hidden name="frontend[{{ $section_key}}][{{ $keys}}][{{$key}}]" type="text"   value="{{$section_data->$key}}" placeholder="{{"Name"}}">
                                                                @endif
                                                                @endif
                                                                
                                                        @endforeach
                                                        @endforeach
                                                @endforeach
                                                @if($frontend->name == 'Header')
                                                    <input type="text" name="status" value="{{\App\Enums\StatusEnum::true->status()}}" hidden>
                                                @else
                                                    <div class="col-12">
                                                        <div class="form-inner">
                                                            <label for="status">
                                                                    {{'Status'}}  <small class="text-danger" >*</small>
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
                                                @endif


                                                <div class="col-12 ">
                                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                        {{"Submit"}}
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
@push('script-include')

    <script src="{{asset('assets/global/js/summernote.min.js')}}"></script>

    <script src="{{asset('assets/global/js/editor.init.js')}}"></script>

@endpush
@push('script-push')
<script>
	(function($){
       	"use strict";
            $(".select2").select2({
			   placeholder:"{{'Select Status'}}",
	     	});

            $(document).on('click','#addNew',function () {
                var form = `
                        @foreach($frontends as $frontend)
                            @php  $frontendSection = $frontend->value @endphp
                            @foreach($frontendSection as $section_key=> $elements)
                                @foreach($elements as $keys=>$section_data)
                                    @foreach($section_data as $key=> $data)
                                        @if($key == 'value')
                                            @if($section_data->type == 'file')
                                                @if($section_key == "dynamic_element")
                                                    <div class="form-group mb-10">
                                                        <div class="input-group">
                                                            <input class="form-control" name="frontend[{{$section_key}}][{{$keys}}][{{$key}}]" type="{{$section_data->type}}" value="{{$section_data->value}}" id="frontend-section">
                                                            <span class="input-group-text pointer delete-option">
                                                                <i class="las  la-times-circle"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @break
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach

                `;
                $('.addedField').append(form)
            });

            $(document).on('click', '.delete-option', function () {
                $(this).closest('.input-group').parent().remove();
            });

	})(jQuery);
</script>
@endpush


