@extends('admin.layouts.master')

@section('content')
    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.staff.bulk")}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_staff') || check_permission('update_staff') || check_permission('delete_staff'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_staff') || check_permission('delete_staff'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_staff'))
                                            <li>
                                                <button  id="deleteModal" class="dropdown-item">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                        @if(request()->routeIs('admin.staff.archive'))
                                            <li>
                                                <button class="dropdown-item" id="bulkActionBtn" data-type ="restore">
                                                    {{translate("Restore")}}
                                                </button>
                                            </li>
                                        @endif
                                        @if(check_permission('update_staff'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" id="bulkActionBtn" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if(request()->routeIs('admin.staff.list'))
                                @if(check_permission('create_staff'))
                                    <div class="col-md-4 d-flex justify-content-start">
                                        <div class="action">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#addStaff" class="i-btn btn--sm success">
                                                <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="action ms-3">
                                    <a href="{{route('admin.staff.archive')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Archive Staff')}}
                                    </a>
                                </div>
                            @else
                                <div class="action ms-3">
                                    <a href="{{route('admin.staff.list')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Staff List')}}
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
                                <a href="{{route('admin.staff.list')}}"  class="i-btn btn--sm danger">
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
                                @if(check_permission('create_staff') || check_permission('update_staff') || check_permission('delete_staff'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Email')}}
                            </th>
                            <th scope="col">
                                {{translate('Phone')}}
                            </th>

                            <th scope="col">
                                {{translate('Created By')}}
                            </th>

                            <th scope="col">
                                {{translate('Last Login Time')}}
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
                        @forelse($staffs->chunk(site_settings('chunk_value')) as $chunkStuffs)
                            @foreach($chunkStuffs as $staff)
                            <tr>
                                <td data-label="#">
                                    @if(check_permission('create_staff') || check_permission('update_staff') || check_permission('delete_staff'))
                                        <input type="checkbox" value="{{$staff->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$staff->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("Name")}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-md" src="{{imageUrl(config("settings")['file_path']['profile']['admin']['path']."/".@$staff->file->name ,@$staff->file->disk ) }}" alt="{{@$staff->file->name}}">
                                        <p>	{{ $staff->name}}</p>
                                        <span class="i-badge capsuled success">
                                            ({{ $staff->role->name }})
                                        </span>

                                    </div>
                                </td>

                                <td data-label="{{translate("Email")}}">
                                    {{$staff->email}}
                                </td>

                                <td data-label="{{translate("Phone")}}">
                                    {{$staff->phone ? $staff->phone : "N/A"}}
                                </td>

                                <td data-label="{{translate("Created By")}}">
                                    <span class="i-badge capsuled info">
                                        {{$staff->createdBy->user_name}}
                                    </span>
                                </td>


                                <td data-label="{{translate("Created By")}}">
                                    <span class="i-badge capsuled info">
                                        {{ $staff->last_login ? diff_for_humans($staff->last_login) : "N/A"}}
                                    </span>
                                </td>

                                <td data-label="{{translate("Status")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input  {{!check_permission('update_staff') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.staff.update.status') }}"
                                            data-model="Admin"
                                            data-status="{{ $staff->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$staff->uid}}" {{$staff->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>


                                <td data-label="{{translate("Action")}}">
                                    <div class="table-action">

                                        @if(check_permission('update_staff') ||  check_permission('delete_staff'))
                                            @if(check_permission('update_staff'))
                                                <a target="_blank" href="{{route('admin.staff.login', $staff->uid)}}" class=" icon-btn success"><i class="las la-sign-in-alt"></i></a>

                                                <a  href="javascript:void(0);" data-uid ="{{$staff->uid}}" class="passwordUpdate   icon-btn warning"><i class="las la-key"></i></a>

                                                <a  href="javascript:void(0);" data-staff ="{{$staff}}" class="update fs-15 icon-btn info"><i class="las la-pen"></i></a>
                                            @endif

                                            @if(check_permission('delete_staff'))

                                                @if(request()->routeIs('admin.staff.list'))
                                                    <form action="{{route('admin.staff.destroy',$staff->id)}}" method="get" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class=" pointer icon-btn danger"><i class="las la-trash-alt"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{route('admin.staff.force.destroy',$staff->id)}}" method="get" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class=" pointer icon-btn danger" id="deleteModal"><i class="las la-trash-alt"></i></button>
                                                    </form>
                                                    <form action="{{route('admin.staff.restore',$staff->id)}}" method="post" enctype="multipart/form-data">
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
                    {{ $staffs->links() }}
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
    <!-- create staff modal -->
    <div class="modal fade" id="addStaff" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{translate('Add Staff')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.staff.store')}}" id="storeModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="name">
                                        {{translate('Name')}}

                                    </label>

                                    <input type="text" name="name" id="name"  placeholder="{{translate("Enter Name")}}"
                                        value="{{old("name")}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="user_name">
                                        {{translate('User Name')}}
                                            <small class="text-danger">*</small>
                                    </label>

                                    <input type="text" name="user_name" id="user_name" placeholder="{{translate("Enter User Name")}}"
                                        value="{{old("user_name")}}" required>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="email">
                                        {{translate('Email')}}
                                            <small class="text-danger">*</small>
                                    </label>

                                    <input type="text" name="email" id="email" placeholder="{{translate("Enter Email")}}"
                                        value="{{old("email")}}" required>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="phone">
                                        {{translate('Phone')}}

                                    </label>

                                    <input type="text" name="phone" id="phone"   placeholder="{{translate("Enter Phone")}}"
                                        value="{{old("phone")}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label class="form-label" for="status">
                                        {{translate('Status')}}
                                            <small class="text-danger">*</small>
                                    </label>

                                    <select class="select2"  name="status" id="status">
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
                                    <label for="role_id">
                                        {{translate('Role')}}
                                    </label>

                                    <select class="selectTwo" name="role_id" id="role_id">
                                        @foreach($roles as $key=>$id)
                                            <option {{old('role_id') == $id ? "selected" :"" }} value="{{$id}}">
                                                {{$key}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label>
                                        {{translate('Profile Image')}}
                                    </label>
                                    <input id="image" name="image" type="file">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="password">
                                        {{translate('Password')}}
                                            <small class="text-danger">*({{translate('Minimum 5 Characters')}})</small>
                                    </label>

                                    <input placeholder="{{translate("Enter Password")}}" type="password" name="password" value="{{old('password')}}">
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

    <!-- update staff modal -->
    <div class="modal fade" id="updateStaff" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{translate('Update Staff')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.staff.update')}}" id="updateModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" class="form-control" >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="Name">
                                        {{translate('Name')}}
                                    </label>
                                    <input type="text" name="name" id="Name" placeholder="{{translate("Enter Name")}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="userName">
                                        {{translate('User Name')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="user_name" id="userName" placeholder="{{translate("Enter User Name")}}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="Email">
                                        {{translate('Email')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="email" id="Email" placeholder="{{translate("Enter Email")}}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="phoneNumber">
                                        {{translate('Phone')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="phone" id="phoneNumber"  placeholder="{{translate("Enter Phone")}}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="roleId">
                                        {{translate('Role')}}
                                    </label>
                                    <select class="selectTwo" name="role_id" id="roleId" >
                                        @foreach($roles as $key=>$id)
                                            <option  value="{{$id}}">
                                                {{$key}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label>
                                        {{translate('Profile Image')}}
                                    </label>
                                    <input id="image" name="image" type="file">
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

    <!-- update password modal -->
    <div class="modal fade" id="updatePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{translate('Update Password')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.staff.update.password')}}" id="updatePasswordForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="uid" id="uid" class="form-control">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label class="form-label" for="password">
                                        {{translate('Password')}} <span class="text-danger" >*</span>

                                    </label>
                                    <input required type="text" name="password" id="password"   placeholder="{{translate("Enter Password")}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label class="form-label" for="password_confirmation">
                                        {{translate('Confirm Password')}}
                                            <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="password_confirmation" name="password_confirmation"   placeholder="{{translate("Enter Confrim Password")}}" required>
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

        $(".select2").select2({
			placeholder:"{{translate('Select Status')}}",
			dropdownParent: $("#addStaff"),
		})

        $(".selectTwo").select2({
			placeholder:"{{translate('Select Status')}}",
			dropdownParent: $("#updateStaff"),
		})

        $(document).on('click','.update',function(e){
            var staff = JSON.parse($(this).attr('data-staff'))
            var modal = $('#updateStaff')
            modal.find('input[name="name"]').val(staff.name)
            modal.find('input[name="user_name"]').val(staff.user_name)
            modal.find('input[name="id"]').val(staff.id)
            modal.find('input[name="email"]').val(staff.email)
            modal.find('input[name="phone"]').val(staff.phone)
            modal.find(`select[name="role_id"] option[value="${staff.role_id}"]`).prop("selected", true);
            modal.modal('show')
        })

        $(document).on('click','.passwordUpdate',function(e){
            var uid = ($(this).attr('data-uid'))
            var modal = $('#updatePassword')
            modal.find('input[name="uid"]').val(uid)
            modal.modal('show')
        })

	})(jQuery);
</script>
@endpush





