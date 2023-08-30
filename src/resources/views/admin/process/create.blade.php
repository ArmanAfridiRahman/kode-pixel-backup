@extends('admin.layouts.master')
@push('style-include')
  <link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
@endpush
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">{{translate('Create Process')}}</h4>
        
        </div>
        <div class="card-body">
            <form action="{{route('admin.process.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
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
                        <div class="form-inner position-unset">
                            <label for="icon">
                                {{translate('Icon')}} <small class="text-danger">*</small>
                            </label>
                            <input type="text" required name="icon" id="icon" class="iconpicker"  placeholder="{{translate("Enter icon")}}"
                                value="{{old("icon")}}">
                        </div>
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="short_description" class="form-label">
                                {{translate('Short Description')}}
                            </label>
                            <textarea maxlength="100" type="text" class="form-control" placeholder="{{translate('Type here')}}"  id="short_description" name="short_description" rows="4">{{old('short_description')}}</textarea>
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
@push('script-include')

<script src="{{asset('assets/global/js/bootstrapicon-iconpicker.js')}}"></script>

@endpush


@push('script-push')
<script>
	(function($){
    "use strict";
        $('.iconpicker').iconpicker({
            title: "{{translate('Search Here !!')}}",
        });


	})(jQuery);
</script>
@endpush






