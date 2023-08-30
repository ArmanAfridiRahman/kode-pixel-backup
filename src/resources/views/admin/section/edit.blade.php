@extends('admin.layouts.master')
@section('content')
    <form action="{{route('admin.section.update')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <input hidden type="text" name="id" value="{{$section->id}}">
        <div class="i-card-md"> 
            <div class="card--header">
                <h4 class="card-title">
                    {{translate("Update Section")}}
                </h4>
            </div>    

            <div class="card-body">
                <div class="row">                  
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="section_name">
                                {{translate('Name')}} <small class="text-danger">*</small>                                  
                            </label>

                            <input type="text" required name="section_name" id="section_name"  placeholder="{{translate("Enter Name")}}"
                                value="{{$section->section_name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="section_title">
                                {{translate('Title')}} <small class="text-danger">*</small>                                  
                            </label>

                            <input type="text" required name="section_title" id="section_title"  placeholder="{{translate("Enter Title")}}"
                                value="{{$section->section_title }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-inner">
                            <label  for="section_description">
                                {{translate('Description')}}
                            </label>
                            <textarea  name="section_description" placeholder="{{translate('Type Description')}}" id="section_description" cols="30" rows="3">{{$section->section_description}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>
                </div>
            </div>       
        </div>    
    </form>
@endsection







