@extends('admin.layouts.master')
@section('content')


    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Update Product')}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.product.update')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}" id="">
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="title" class="form-label" >
                                {{translate('Title')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Title')}}" id="title" name="title" value="{{$product->title}}">
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="image" class="form-label">
                                {{translate('Image')}} <small class="text-danger">({{config("settings")['file_path']['product_method']['size']}})*</small>
                            </label>

                            <input data-size = {{config("settings")['file_path']['product_method']['size']}} id="image" name="image" type="file" class="preview" value="{{$product->image}}" >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mt-2" id="image-preview-section">
                            <img src="{{imageUrl(config("settings")['file_path']['product_method']['path']."/".@$product->file->name ,@$product->file->disk ) }}" alt="{{@$product->file->name}}" class="product-image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="rating" class="form-label" >
                                {{translate('Rating')}}
                            </label>
                            <input type="text" placeholder="{{translate('Enter Rating')}}" id="rating" name="rating" value="{{$product->rating}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="url" class="form-label" >
                                {{translate('Url')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Url')}}" id="url" name="url" value="{{$product->url}}">
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <div class="form-inner">
                            <label for="short_description" class="form-label">
                                {{translate('Short Description')}} 
                            </label>
                            <textarea type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="short_description" name="short_description" rows="4">{{$product->short_description}}</textarea>
                        </div>
                    </div>  
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="message" class="form-label" >
                                {{translate('Message')}} 
                            </label>
                            <input type="text" placeholder="{{translate('Enter Message')}}" id="message" name="message" value="{{$product->message}}">
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



