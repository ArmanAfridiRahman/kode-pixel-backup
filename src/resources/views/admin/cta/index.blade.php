@extends('admin.layouts.master')

@section('content')

    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.cta.bulk")}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_cta') || check_permission('update_cta') || check_permission('delete_cta'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_cta') || check_permission('delete_cta'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_cta'))
                                            <li>
                                                <button  id="deleteModal" class="dropdown-item">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                            @if(request()->routeIs('admin.cta.archive'))
                                                <li>
                                                    <button class="dropdown-item" id="bulkActionBtn" data-type ="restore">
                                                        {{translate("Restore")}}
                                                    </button>
                                                </li>
                                            @endif
                                        @if(check_permission('update_cta'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" id="bulkActionBtn" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if(request()->routeIs('admin.cta.list'))
                                @if(check_permission('create_cta'))
                                <div class="col-md-4 d-flex justify-content-start">
                                        <div class="action">
                                            <button type="button"   data-bs-toggle="modal" data-bs-target="#addCta" class="i-btn btn--sm success">
                                                <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                            </button>
                                        </div>
                                </div>
                                @endif
                                <div class="action ms-3">
                                    <a href="{{route('admin.cta.archive')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Archive Cta')}}
                                    </a>
                                </div>
                            @else
                                <div class="action ms-3">
                                    <a href="{{route('admin.cta.list')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Cta List')}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-8 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">

                                <div class="form-inner">
                                      <input name="name" value="{{request()->name}}" type="search" placeholder="{{translate('Search By Name')}}">
                                </div>

                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route('admin.cta.list')}}"  class="i-btn btn--sm danger">
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
                                @if(check_permission('create_cta') || check_permission('update_cta') || check_permission('delete_cta'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
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

                        @forelse($ctas->chunk(site_settings('chunk_value')) as $chunkCtas)
                            @foreach($chunkCtas as $cta)
                                <tr>
                                <td data-label="#">
                                    @if(check_permission('create_cta') || check_permission('update_cta') || check_permission('delete_cta'))
                                        <input type="checkbox" value="{{$cta->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$cta->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("Name")}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-md" src="{{imageUrl(config("settings")['file_path']['cta']['path']."/".@$cta->file->name ,@$cta->file->disk ) }}" alt="{{@$cta->file->name}}">
                                        <p>	{{ $cta->title}}</p>

                                    </div>
                                </td>


                                <td data-label="{{translate("Created By")}}">
                                    <span class="i-badge capsuled info">
                                        {{$cta->createdBy->user_name}}
                                    </span>
                                </td>

                                <td data-label="{{translate("Status")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_cta') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.cta.update.status') }}"
                                            data-model="Admin"
                                            data-status="{{ $cta->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$cta->uid}}" {{$cta->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>


                                <td data-label="{{translate("Options")}}">
                                    <div class="table-action">

                                        @if(check_permission('update_cta') ||  check_permission('delete_cta'))
                                            @if(check_permission('update_cta'))

                                                <a  href="javascript:void(0);" data-cta ="{{$cta}}" class="update fs-15 icon-btn info"><i class="las la-pen"></i></a>
                                            @endif

                                            @if(check_permission('delete_cta'))
                                                    @if(request()->routeIs('admin.cta.list'))
                                                        <form action="{{route('admin.cta.destroy',$cta->id)}}" method="get" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class=" pointer icon-btn danger"><i class="las la-trash-alt"></i></button>
                                                        </form>
                                                    @else
                                                        <form action="{{route('admin.cta.force.destroy',$cta->id)}}" method="get" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class=" pointer icon-btn danger" id="deleteModal"><i class="las la-trash-alt"></i></button>
                                                        </form>
                                                        <form action="{{route('admin.cta.restore',$cta->id)}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="pointer icon-btn success"><i class="las la-trash-restore-alt"></i></button>
                                                        </form>
                                                    @endif
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
                    {{ $ctas->links() }}
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
    <!-- create cta modal -->
    <div class="modal fade" id="addCta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{translate('Add Cta')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.cta.store')}}" id="storeModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="title">
                                        {{translate('Title')}} <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" required name="title" id="title"  placeholder="{{translate("Enter title")}}"
                                        value="{{old("title")}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label>
                                        {{translate('Image')}} <small class="text-danger">*({{config("settings")['file_path']['cta']['size']}})</small>
                                    </label>
                                    <input id="image" name="image" type="file" >
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="description">
                                        {{translate('Description')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <textarea placeholder="{{translate('Type Here')}}" name="description" id="" cols="30" rows="5">{{old("description")}}</textarea>
                                </div>
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

    <!-- update cta modal -->
    <div class="modal fade" id="updatecta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{translate('Update Cta')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.cta.update')}}" id="updateModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" class="form-control" >

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="title">
                                        {{translate('Title')}} <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="title" id="title" placeholder="{{translate("Enter title")}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label>
                                        {{translate('Profile Image')}}  <small class="text-danger">*({{config("settings")['file_path']['cta']['size']}})</small>
                                    </label>
                                    <input id="image" name="image" type="file">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="description">
                                        {{translate('Description')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <textarea placeholder="{{translate('Type Here')}}" name="description" id="" cols="30" rows="5"></textarea>
                                </div>
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
        $(document).on('click','.update',function(e){
            var cta = JSON.parse($(this).attr('data-cta'))
            var modal = $('#updatecta')
            modal.find('input[name="title"]').val(cta.title)
            modal.find('input[name="id"]').val(cta.id)

            modal.find('textarea[name="description"]').html(cta.description)

            modal.modal('show')
        })
	})(jQuery);
</script>
@endpush





