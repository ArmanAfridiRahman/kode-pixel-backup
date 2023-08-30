@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.product.bulk")}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_product') || check_permission('update_product') || check_permission('delete_product'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_product') || check_permission('delete_product'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('delete_product'))
                                            <li>
                                                <button  id="deleteModal" class="dropdown-item">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                        @if(check_permission('update_product'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" id="bulkActionBtn" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if(check_permission('create_product'))
                                <div class="action">
                                    <a href="{{route('admin.product.create')}}" class="i-btn btn--sm btn--success">
                                        <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                        <div class="col-md-8 d-flex justify-content-md-end justify-content-start">
                            <div class="search-area">
                                <form action="{{route('admin.product.list')}}" method="get">
                                    <div class="form-inner">
                                        <input name="title" value="{{@$search}}" type="search" placeholder="{{translate('Search By Title')}}">
                                    </div>

                                    <button class="i-btn btn--sm btn--primary">
                                        <i class="bi bi-filter me-2"></i>
                                    </button>
                                    <a href="{{route('admin.product.list')}}"  class="i-btn btn--sm btn--primary">
                                        <i class="las la-sync"></i>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">
                            @if(check_permission('create_product') || check_permission('update_product') || check_permission('delete_product'))
                                <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                        <th scope="col">{{translate('Title')}}</th>
                        <th scope="col">{{translate('URL')}}</th>
                        <th scope="col">{{translate('Rating')}}</th>
                        <th scope="col">{{translate('Status')}}</th>
                        <th scope="col">{{translate('Action')}}</th>
                    </tr>
                    </thead>
                    <div class="d-none" id="mark-option">
                        <div class="option-dropdown">
                            <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <p>Choose an Action</p>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        @forelse ($products->chunk(site_settings('chunk_value')) as $chunkProducts)
                            @foreach($chunkProducts as $product)
                            <tr>
                                <td data-label="#">
                                    @if(check_permission('create_product') || check_permission('update_product') || check_permission('delete_product'))
                                        <input type="checkbox" value="{{$product->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$product->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("title")}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-md"  src="{{imageUrl(config("settings")['file_path']['product_method']['path']."/".@$product->file->name ,@$product->file->disk ) }}" alt="{{@$product->file->name}}">
                                        <p>{{$product->title}}</p>
                                    </div>
                                </td>
                                <td data-label="{{translate("rating")}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <p>{{$product->rating}}</p>
                                    </div>
                                </td>
                                <td data-label="{{translate("url")}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <p>{{$product->url}}</p>
                                    </div>
                                </td>
                                <td data-label="{{translate("Status")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_plan') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.product.update.status') }}"
                                            data-status="{{ $product->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$product->uid}}" {{$product->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>
                                <td data-label="{{translate("Action")}}">
                                    <div class="table-action">
                                        @if(check_permission('update_product') || check_permission('delete_product') )
                                            @if(check_permission('update_product'))
                                                <a  href="{{route('admin.product.edit',$product->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
                                            @endif
                                            @if(check_permission('delete_product'))
                                                <a href="javascript:void(0);" data-href="{{route('admin.product.destroy',$product->uid)}}" class=" pointer delete-item icon-btn danger">
                                                <i class="las la-trash-alt"></i></a>
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






