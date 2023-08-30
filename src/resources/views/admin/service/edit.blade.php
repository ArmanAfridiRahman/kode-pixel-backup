@extends('admin.layouts.master')
@section('content')


    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Update Service')}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.service.update')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$service->id}}" id="">
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="title" class="form-label" >
                                {{translate('Name')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Title')}}" id="title" name="title" value="{{$service->title}}">
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="image" class="form-label">
                                {{translate('Image')}} <small class="text-danger">({{config("settings")['file_path']['service_method']['size']}})</small>
                            </label>

                            <input data-size = {{config("settings")['file_path']['service_method']['size']}} id="image" name="image" type="file" class="preview" value="{{$service->image}}" >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mt-2" id="image-preview-section">
                            <img src="{{imageUrl(config("settings")['file_path']['service_method']['path']."/".@$service->file->name ,@$service->file->disk ) }}" alt="{{@$service->file->name}}" class="service-image">
                        </div>
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="short_description" class="form-label">
                                {{translate('Short Description')}} 
                            </label>
                            <textarea required type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="short_description" name="short_description" rows="4">{{$service->short_description}}</textarea>
                        </div>
                    </div>  
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="long_description" class="form-label">
                                {{translate('Long Description')}} 
                            </label>
                            <textarea required type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="long_description" name="long_description" rows="4">{{$service->long_description}}</textarea>
                        </div>
                    </div>  
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <a href="javascript:void(0)" class="i-btn btn--sm btn--success" id="addNew">  <i class="las la-plus me-1"></i> {{translate('Add Field')}}</a>
                        </div>
                    </div>
                
                    <div class="col-12">
                        <div class="addedField form-inner">
                            @foreach ($service->parameters as $parameter)                         
                                <div class="form-group mb-10">
                                    <div class="input-group">      
                                        <input name="service_name[]" class="form-control" type="text" value="{{$parameter->field_label}}" required placeholder="{{translate('Service Name')}}">
        
                                        <span class="input-group-text pointer delete-option">
                                            
                                            <i class="las la-times-circle"></i>
                                            
                                        </span>
                                    </div>
                                </div>
                            @endforeach                           
                        </div>
                    </div> 


                    <div class="col-12">
                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>




                </div>
            </form>
        </div>
    </div>

@endsection
@push('script-push')
<script>
	(function($){
       	"use strict";
            $(document).on('click','#addNew',function () {
                var form = `
                            <div class="form-group mb-10">
                                <div class="input-group">
                                    <input name="service_name[]" class="form-control " type="text" value="" required placeholder="{{translate('Service Name')}}">

                            

                                    <span class="input-group-text pointer delete-option  ">
                                            <i class="las  la-times-circle"></i>
                                    </span>
                                </div>
                            </div>
                            `;

                $('.addedField').append(form)
            });


            $(document).on('click', '.delete-option', function () {
                $(this).closest('.input-group').parent().remove();
            });
	})(jQuery);
</script>
@endpush


