@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Create Team')}}</h4>
        
        </div>
        <div class="card-body">
            <form action="{{route('admin.team.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="name" class="form-label" >
                                {{translate('Name')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Team Member Name')}}" id="name" name="name" value="{{old('Name')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="designation" class="form-label" >
                                {{translate('Designation')}} <small class="text-danger">*</small>
                            </label>
                            <input required type="text" placeholder="{{translate('Enter Designation')}}" id="designation" name="designation" value="{{old('Designation')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="image" class="form-label">
                                {{translate('Image')}} 
                                <small class="text-danger">({{config("settings")['file_path']['team_method']['size']}})</small>
                            </label>
                            <input data-size={{config("settings")['file_path']['team_method']['size']}} id="image" name="image" type="file" class="preview">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class=" form-inner" id="image-preview-section">
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







