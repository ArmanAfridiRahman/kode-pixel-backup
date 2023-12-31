@extends('admin.layouts.master')


@section('content')

    <div class="i-card-md">
       <div class="card--header">
            <h4 class="card-title">
                {{translate("Mail Gateway Lists")}}
            </h4>


       </div>

        <div class="card-body">

            <div class="search-action-area">
                <div class="d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">
                            <div class="form-inner">

                                <input name="name" value="{{request()->name}}" type="search" placeholder="{{translate('Search By Name')}}">

                            </div>
                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>

                            <a href="{{route('admin.mailGateway.list')}}"  class="i-btn btn--sm danger">
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
                            <th>#</th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>

                            <th scope="col">
                                {{translate('Default')}}
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
                        @forelse($gateways->chunk(site_settings('chunk_value')) as $chunkGateways)
                            @foreach($chunkGateways as $gateway)
                                <tr>
                                <td data-label="#">
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate('Name')}}">
                                    {{$gateway->name}}
                                </td>


                                <td data-label="{{translate("Status")}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_gateway') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.mailGateway.update.status') }}"
                                            data-status="{{ $gateway->default == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$gateway->uid}}" {{$gateway->default ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch" >
                                        <label class="form-check-label" for="status-switch"></label>
                                    </div>
                                </td>


                                <td data-label="{{translate("Updated By")}}">
                                    <span class="i-badge capsuled info">
                                        {{$gateway->updatedBy->name}}
                                    </span>

                                </td>



                                <td data-label="{{translate("Options")}}">
                                    <div class="table-action">

                                        @if(check_permission('update_gateway') &&  $gateway->code != "104PHP")
                                        <a  href="{{route('admin.mailGateway.edit',$gateway->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
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



