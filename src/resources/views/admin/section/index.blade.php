@extends('admin.layouts.master')

@section('content')

    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.section.bulk")}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_section') || check_permission('update_section') || check_permission('delete_section'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_section') || check_permission('delete_section'))
                            <div class="i-dropdown bulk-action d-none">
                                <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="las la-cogs fs-15"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @if(check_permission('delete_section'))
                                        <li>
                                            <button  id="deleteModal" class="dropdown-item">
                                                {{translate("Delete")}}
                                            </button>
                                        </li>
                                    @endif
                                    @if(check_permission('update_section'))
                                        @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                            <li>
                                                <button type="button" id="bulkActionBtn" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item" > {{translate($k)}}</button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            @endif
                            @if(check_permission('create_section'))
                                <div class="col-md-4 d-flex justify-content-start">
                                    <div class="action">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#addSection" class="i-btn btn--sm success">
                                            <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif


                    <div class="col-md-8 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">
                                <div class="form-inner">
                                    <input name="name" name="{{request()->name}}" type="search" placeholder="{{translate('Search By Name')}}">
                                </div>

                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route('admin.section.list')}}"  class="i-btn btn--sm danger">
                                    <i class="las la-sync"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                @if(check_permission('create_section') || check_permission('update_section') || check_permission('delete_section'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>

                            <th scope="col">
                                {{translate('Title')}}
                            </th>

                            <th scope="col">
                                {{translate('Created By')}}
                            </th>

                            <th scope="col">
                                {{translate('Status')}}
                            </th>

                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sections->chunk(site_settings('chunk_value')) as $chunkSections)
                            @foreach($chunkSections as $section)
                                <tr>
                                <td data-label="#">
                                    @if(check_permission('create_section') || check_permission('update_section') || check_permission('delete_section'))
                                        <input type="checkbox" value="{{$section->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$section->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("Name")}}">
                                    {{ $section->section_name}}
                                </td>
                                <td data-label="{{translate("Title")}}">
                                    {{$section->section_title}}
                                </td>
                                <td data-label="{{translate("Created By")}}">
                                    <span class="i-badge capsuled info">
                                        {{$section->createdBy->user_name}}
                                    </span>
                                </td>

                                <td data-label="{{translate("Status")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_section') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.section.update.status') }}"

                                            data-status="{{ $section->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$section->uid}}" {{$section->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>

                                <td data-label="{{translate("Action")}}">
                                    <div class="table-action">

                                        @if(check_permission('update_section') ||  check_permission('delete_section'))
                                            @if(check_permission('update_section'))

                                                <a  href="{{route('admin.section.edit',$section->uid)}}"  class=" fs-15 icon-btn info"><i class="las la-pen"></i></a>
                                            @endif

                                            @if(check_permission('delete_section'))
                                                    
                                                <form action="{{route('admin.section.destroy',$section->id)}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class=" pointer icon-btn danger"><i class="las la-trash-alt"></i></button>
                                                </form>
                                                   
                                            @endif

                                        @else
                                            {{translate('N/A')}}
                                        @endif


                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td class="border-bottom-0" colspan="100%">
                                    @include('admin.partials.not_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="Paginations">
                <ul class="Pagination">
                    {{ $sections->links() }}
                </ul>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <!-- bulk delete modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content notification-modal">
            <div class="modal-body">
                <div class="modal-delete-noti">
                    <div class="notification-modal-icon">
                        <img src="{{asset('assets/images/trash-bin.gif')}}" alt="trash-bin.gif">
                    </div>
                    <div class="notification-modal-content">
                        <h5>   {{translate(Arr::get(config('language'),'are_you_sure','are_you_sure'))}}</h5>
                        <p class="warning-message">
                             {{translate('Do You Want To Delete These Records??')}}
                        </p>
                    </div>
                </div>
                    <div class="#modalDelete modal-footer">
                        <button type="button"
                            class="i-btn btn--lg bg-soft-warning"
                            data-bs-dismiss="modal">
                            {{translate("No")}}
                        </button>
                       <button  id="bulkActionBtn"  data-type ="delete" name="bulk_status" value="delete"  class="i-btn btn--lg delete-btn btn-delete">
                           {{translate("Delete")}}
                       </button>
                    </div>
            </div>
        </div>
    </div>
</div>
    <!-- create section modal -->
    <div class="modal fade" id="addSection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{translate('Add Section')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.section.store')}}" id="storeModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="section_name">
                                        {{translate('Name')}} <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" required name="section_name" id="section_name"  placeholder="{{translate("Enter Name")}}"
                                        value="{{old("section_name")}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="section_title">
                                        {{translate('Title')}} <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" required name="section_title" id="section_title"  placeholder="{{translate("Enter Title")}}"
                                        value="{{old("section_title")}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <label  for="section_description">
                                        {{translate('Description')}}
                                    </label>
                                    <textarea  name="section_description" placeholder="{{translate('Type Description')}}" id="section_description" cols="30" rows="3">{{old('section_description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="status">
                                        {{translate('Status')}}
                                            <small class="text-danger">*</small>
                                    </label>

                                    <select class="select2" name="status" id="status">
                                        @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                                            <option {{old('status') == $value ? "selected" :"" }} value="{{$value}}">
                                                {{$status}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label>
                                        {{translate('Section Image')}}
                                    </label>
                                    <input id="image" name="image" type="file">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class=" form-inner" id="image-preview-section">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--md ripple-dark" anim="ripple" data-bs-dismiss="modal">
                            {{translate("Close")}}
                        </button>
                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>
                </form>
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
			dropdownParent: $("#addSection"),
		})

	})(jQuery);
</script>

@endpush







