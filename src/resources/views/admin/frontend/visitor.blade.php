
@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{translate('Visitor List')}}
            </h4>
        </div>

        <div class="card-body">
            <div class="search-action-area ">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.frontend.visitor.bulk")}}" method="post">
                        @csrf
                        <input type="hidden" name="bulk_id" id="bulkid">
                        <input type="hidden" name="value" id="value">
                        <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_frontend') || check_permission('update_frontend') || check_permission('delete_frontend'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_frontend') || check_permission('delete_frontend'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_frontend'))
                                            <li>
                                                <button  id="deleteModal" class="dropdown-item">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                        @if(request()->routeIs('admin.frontend.visitor.archive'))
                                            <li>
                                                <button class="dropdown-item" id="bulkActionBtn" data-type ="restore">
                                                    {{translate("Restore")}}
                                                </button>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            @endif
                            @if(request()->routeIs('admin.frontend.visitor'))
                                <div class="action ms-3">
                                    <a href="{{route('admin.frontend.visitor.archive')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Archive Visitor')}}
                                    </a>
                                </div>
                            @else
                                <div class="action ms-3">
                                    <a href="{{route('admin.frontend.visitor')}}" class="i-btn btn--sm btn--success">
                                        {{translate('Show Visitor List')}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">
                                <div class="form-inner">
                                      <input name="ip" value="{{request()->ip}}" type="search" placeholder="{{translate('Search By Ip')}}">
                                </div>

                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route('admin.frontend.visitor')}}"  class="i-btn btn--sm danger">
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
                                @if(check_permission('create_frontend') || check_permission('update_frontend') || check_permission('delete_frontend'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>

                            <th scope="col">
                                {{translate('Ip')}}
                            </th>


                            <th scope="col">
                                {{translate('Last Visitsed At')}}
                            </th>

                            <th scope="col">
                                {{translate('Blocked')}}
                            </th>


                            <th scope="col">
                                {{translate('Updated By')}}
                            </th>


                            <th scope="col">
                                {{translate('Options')}}
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse($visitors->chunk(site_settings('chunk_value')) as $chunkVisitors)
                            @foreach($chunkVisitors as $visitor)
                                <tr>
                                <td data-label="#">
                                    @if(check_permission('create_frontend') || check_permission('update_frontend') || check_permission('delete_frontend'))
                                        <input type="checkbox" value="{{$visitor->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$visitor->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("Ip")}}">
                                     {{$visitor->ip_address}}
                                </td>
                                <td data-label="{{translate("Subscribe At")}}">
                                    {{diff_for_humans($visitor->updated_at)}}
                                </td>

                                <td data-label="{{translate("Blocked")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_frontend') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="is_blocked"
                                            data-route="{{ route('admin.frontend.visitor.ip.status') }}"
                                            data-status="{{ $visitor->is_blocked == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$visitor->id}}" {{$visitor->is_blocked ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>


                                <td data-label="{{translate("Updated by")}}">
                                    <span class="i-badge capsuled info">
                                        {{$visitor->updatedBy->name}}
                                    </span>
                                </td>



                                <td data-label="{{translate("Options")}}">
                                    <div class="table-action">

                                        @if(check_permission('update_frontend'))
                                            @if(request()->routeIs('admin.frontend.visitor'))

                                            <a href="javascript:void(0);" data-href="{{route('admin.frontend.ip.destroy',$visitor->ip_address)}}" class="delete-item icon-btn danger">
                                                <i class="las la-trash-alt"></i></a>
                                            @else
                                                <form action="{{route('admin.frontend.visitor.force.destroy',$visitor->id)}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class=" pointer icon-btn danger" id="deleteModal"><i class="las la-trash-alt"></i></button>
                                                </form>
                                                <form action="{{route('admin.frontend.visitor.restore',$visitor->id)}}" method="post" enctype="multipart/form-data">
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

            <div class="Paginations">
                <ul class="Pagination">
                    {{ $visitors->links() }}
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
@endsection










