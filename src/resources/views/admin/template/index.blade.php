@extends('admin.layouts.master')
@section('content')

    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{translate("Template List")}}
            </h4>
        </div>

        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.template.bulk")}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_template') || check_permission('update_template') || check_permission('delete_template'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_template') || check_permission('delete_template'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_template'))
                                            <li>
                                                <button  id="deleteModal" class="dropdown-item">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                            @if(request()->routeIs('admin.template.archive'))
                                                <li>
                                                    <button class="dropdown-item" id="bulkActionBtn" data-type ="restore">
                                                        {{translate("Restore")}}
                                                    </button>
                                                </li>
                                            @endif
                                        @if(check_permission('update_template'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" id="bulkActionBtn" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if(request()->routeIs('admin.template.list'))
                                <div class="action ms-3">
                                    <a href="{{route('admin.template.archive')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Archive Template')}}
                                    </a>
                                </div>
                            @else
                                <div class="action ms-3">
                                    <a href="{{route('admin.template.list')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Template List')}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">
                            <div class="form-inner">
                                <input name="name" name="{{request()->name}}" type="search" placeholder="{{translate('Search By Name')}}">

                            </div>
                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route('admin.template.list')}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                @if(check_permission('create_template') || check_permission('update_template') || check_permission('delete_template'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>

                            <th scope="col">
                                {{translate('Subject')}}
                            </th>

                            <th scope="col">
                                {{translate('Updated By')}}
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
                        @forelse($templates->chunk(site_settings('chunk_value')) as $chunkTemplates)
                            @foreach($chunkTemplates as $template)
                                <tr>
                                <td data-label="#">
                                    @if(check_permission('create_template') || check_permission('update_template') || check_permission('delete_template'))
                                        <input type="checkbox" value="{{$template->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$template->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate('Name')}}">
                                    {{$template->name}}
                                </td>

                                <td data-label="{{translate('Subject')}}">
                                    {{ limit_words($template->subject,20)}}
                                </td>

                                <td data-label="{{translate('Updated By')}}">
                                    <span class="i-badge capsuled info">
                                        {{$template->createdBy->user_name}}
                                    </span>
                                </td>

                                <td data-label="{{translate("Status")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_template') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.template.update.status') }}"
                                            data-status="{{ $template->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$template->uid}}" {{$template->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>

                                <td data-label="{{translate("Options")}}">
                                    <div class="table-action">
                                        @if(check_permission('update_template'))
                                        <a  href="{{route('admin.template.edit',$template->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
                                            @if(request()->routeIs('admin.template.list'))
                                                <a href="javascript:void(0);" data-href="{{route('admin.template.destroy',$template->uid)}}" class=" pointer delete-item icon-btn danger">

                                                    <i class="las la-trash-alt"></i></a>
                                            @else
                                                <form action="{{route('admin.template.force.destroy',$template->id)}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class=" pointer icon-btn danger" id="deleteModal"><i class="las la-trash-alt"></i></button>
                                                </form>
                                                <form action="{{route('admin.template.restore',$template->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class="pointer icon-btn success"><i class="las la-trash-restore-alt"></i></button>
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
@endsection


