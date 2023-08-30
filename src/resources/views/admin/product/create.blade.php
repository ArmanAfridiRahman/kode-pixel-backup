@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Create Portfolio')}}</h4>
        
        </div>
        <div class="card-body">
            <form action="{{route('admin.portfolio.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
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
                                <small class="text-danger">({{config("settings")['file_path']['portfolio_method']['size']}})*</small>
                            </label>
                            <input data-size={{config("settings")['file_path']['portfolio_method']['size']}} id="image" name="image" type="file" class="preview">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class=" form-inner" id="image-preview-section">
                    </div>
                      
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="rating" class="form-label" >
                                {{translate('Rating')}} 
                            </label>
                            <input  type="number" placeholder="{{translate('Enter Rating')}}" id="rating" name="rating" value="{{old('Rating')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="url" class="form-label" >
                                {{translate('URL')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter URL')}}" id="url" name="url" value="{{old('URL')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="short_description" class="form-label">
                                {{translate('Short Description')}}
                            </label>
                            <textarea maxlength="150" type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="short_description" name="short_description" rows="4">{{old('short_description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="message" class="form-label" >
                                {{translate('Message')}} 
                            </label>
                            <input type="text" placeholder="{{translate('Enter Message')}}" id="message" name="message" value="{{old('Message')}}">
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







