@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Create Service')}}</h4>
        
        </div>
        <div class="card-body">
            <form action="{{route('admin.service.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="title" class="form-label" >
                                {{translate('Title')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Title')}}" id="title" name="title" value="{{old('Title')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="image" class="form-label">
                                {{translate('Image')}} 
                                <small class="text-danger">({{config("settings")['file_path']['service_method']['size']}})</small>
                            </label>
                            <input data-size = {{config("settings")['file_path']['service_method']['size']}} id="image" name="image" type="file" class="preview">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class=" form-inner" id="image-preview-section">
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="short_description" class="form-label">
                                {{translate('Short Description')}}
                            </label>
                            <textarea maxlength="150" type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="short_description" name="short_description" rows="4">{{old('short_description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="long_description" class="form-label">
                                {{translate('Long Description')}}
                            </label>
                            <textarea maxlength="300" type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="long_description" name="long_description" rows="4">{{old('long_description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <a href="javascript:void(0)" class="i-btn btn--sm btn--success" id="addNew">  <i class="las la-plus me-1"></i> {{translate('Add Service')}}</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="addedField form-inner">
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
                                    <input name="service_name[]" class="form-control" type="text" placeholder="{{translate('Service Name')}}">

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






