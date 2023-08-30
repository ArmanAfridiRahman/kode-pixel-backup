@extends('admin.layouts.master')
@section('content')


    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Update Team')}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.team.update')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$team->id}}" id="">
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="title" class="form-label" >
                                {{translate('Title')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Title')}}" id="title" name="title" value="{{$team->title}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="url" class="form-label" >
                                {{translate('Url')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Url')}}" id="url" name="url" value="{{$team->url}}">
                        </div>
                    </div>
                    
                   
                    <div class="col-lg-12 mt-4">
                        <div class="form-inner">
                            <label for="short_description" class="form-label">
                                {{translate('Short Description')}} 
                            </label>
                            <textarea required type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="short_description" name="short_description" rows="4">{{$team->short_description}}</textarea>
                        </div>
                    </div>  
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="image" class="form-label">
                                {{translate('Image')}} <small class="text-danger">({{config("settings")['file_path']['team_method']['size']}})</small>
                            </label>

                            <input data-size = {{config("settings")['file_path']['team_method']['size']}} id="image" name="image" type="file" class="preview" value="{{$team->image}}" >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mt-2" id="image-preview-section">
                            <img src="{{imageUrl(config("settings")['file_path']['team_method']['path']."/".@$team->file->name ,@$team->file->disk ) }}" alt="{{@$team->file->name}}" class="team-image">
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



