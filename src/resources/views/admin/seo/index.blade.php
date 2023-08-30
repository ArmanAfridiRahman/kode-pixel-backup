
@extends('admin.layouts.master')

@section('content')


    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{translate("Seo Items")}}
            </h4>


        </div>

        <div class="card-body">

            <div class="search-action-area">
                <div class="d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                <input name="title" value="{{request()->title}}" type="search" placeholder="{{translate('Search By Title')}}">
                            </div>

                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route('admin.seo.list')}}"  class="i-btn btn--sm danger">
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
                            <th scope="col">#</th>
                            <th scope="col">
                                {{translate('Page Title')}}
                            </th>

                            <th scope="col">
                                {{translate('Url Slug')}}
                            </th>

                            <th scope="col">
                                {{translate('Meta Title')}}
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
                        @forelse($seos->chunk(site_settings('chunk_value')) as $chunkSeos)
                            @foreach($chunkSeos as $seo)
                                <tr>
                                <td data-label="#">
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("Page Title")}}">
                                        {{@get_translation($seo->title)}}
                                </td>
                                <td data-label="{{translate("Url Slug")}}">
                                    {{@($seo->slug)}}
                                </td>


                                <td data-label="{{translate("Meta Title")}}">
                                    {{@get_translation($seo->meta_title)}}
                                </td>

                                <td data-label="{{translate("Updated By")}}">
                                    <span class="i-badge capsuled info">
                                        {{$seo->updatedBy->user_name}}
                                    </span>
                                </td>


                                <td data-label="{{translate("Action")}}">
                                    <div class="table-action">
                                        @if(check_permission('update_frontend'))
                                            @if(check_permission('update_frontend'))
                                                <a  href="{{route('admin.seo.edit',$seo->uid)}}" class="update fs-15 icon-btn info"><i class="las la-pen"></i></a>
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




