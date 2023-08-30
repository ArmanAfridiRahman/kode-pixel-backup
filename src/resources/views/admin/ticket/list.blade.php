@extends('admin.layouts.master')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="i-card-sm style-2 warning">
          <div class="icon">
            <i class="las la-comment-slash"></i>
          </div>
          <div class="card-info">
            <h5 class="title">
               {{translate("Pending Ticket")}}
            </h5>

            <h3>
                {{Arr::get($counter,'pending',0)}}
            </h3>
            <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::PENDING->value])}}" class="mt-3 i-btn btn--white btn--sm">
              {{translate("View All")}}
           </a>
          </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="i-card-sm style-2 danger">
        <div class="icon">
            <i class="las la-comment"></i>
        </div>
        <div class="card-info">
          <h5 class="title">
             {{translate("Closed Ticket")}}
          </h5>

          <h3> {{Arr::get($counter,'closed',0)}}</h3>
          <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::CLOSED->value])}}" class="mt-3 i-btn btn--white btn--sm">
            {{translate("View All")}}
         </a>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="i-card-sm style-2 info">
          <div class="icon">
            <i class="las la-sms"></i>
          </div>
          <div class="card-info">
            <h5 class="title">
                {{translate("Holds Ticket")}}
            </h5>
            <h3>{{Arr::get($counter,'hold',0)}}</h3>

            <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::HOLD->value])}}" class="mt-3 i-btn btn--white btn--sm">
               {{translate("View All")}}
            </a>
          </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="i-card-sm style-2 success">
        <div class="icon">
            <i class="las la-envelope-open"></i>
        </div>
        <div class="card-info">
          <h5 class="title">
             {{translate("Solved Ticket")}}
          </h5>
          <h3>{{Arr::get($counter,'solved',0)}}</h3>

          <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::SOLVED->value])}}" class="mt-3 i-btn btn--white btn--sm">
             {{translate("View All")}}
          </a>
        </div>
      </div>
    </div>

</div>

<div class="i-card-md">
    <div class="card--header">
        <h4 class="card-title">
            {{translate('Tickets')}}
        </h4>
    </div>

    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-4">
                <form hidden id="bulkActionForm" action="{{route("admin.ticket.bulk")}}" method="post">
                    @csrf
                     <input type="hidden" name="bulk_id" id="bulkid">
                     <input type="hidden" name="value" id="value">
                     <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_ticket') || check_permission('update_ticket') || check_permission('delete_ticket'))
                    <div class="col-md-4 d-flex justify-content-start">
                        @if(check_permission('update_ticket') || check_permission('delete_ticket'))
                            <div class="i-dropdown bulk-action d-none">
                                <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="las la-cogs fs-15"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @if(check_permission('update_ticket'))
                                        <li>
                                            <button  id="deleteModal" class="dropdown-item">
                                                {{translate("Delete")}}
                                            </button>
                                        </li>
                                    @endif
                                        @if(request()->routeIs('admin.ticket.archive'))
                                            <li>
                                                <button class="dropdown-item" id="bulkActionBtn" data-type ="restore">
                                                    {{translate("Restore")}}
                                                </button>
                                            </li>
                                        @endif
                                    @if(check_permission('update_ticket'))
                                        @foreach(App\Enums\TicketStatus::toArray() as $k => $v)
                                            <li>
                                                <button type="button" id="bulkActionBtn" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item" > {{translate($k)}}</button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
                @if(request()->routeIs('admin.ticket.list'))
                    <div class="action ms-3">
                        <a href="{{route('admin.ticket.archive')}}" class="i-btn btn--sm btn--success">
                            {{translate('Show Archive Ticket')}}
                        </a>
                    </div>
                @else
                    <div class="action ms-3">
                        <a href="{{route('admin.ticket.list')}}" class="i-btn btn--sm btn--success">
                            {{translate('Show Ticket List')}}
                        </a>
                    </div>
                @endif
                <div class="col-md-12 d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                <input type="text" value="{{request()->input('ticket_number')}}"  name="ticket_number" placeholder="{{translate("Enter Ticket Number")}}">

                            </div>

                            <div class="form-inner">
                                <select name="status" class="select2" id="priority">
                                    <option value="">{{translate("Select Status")}}</option>
                                    @foreach(App\Enums\TicketStatus::toArray() as $k => $v)
                                       <option {{request()->input('status') ==  $v ? "selected" :"" }} value="{{$v}}">
                                           {{ucfirst(strtolower($k))}}
                                       </option>
                                    @endforeach
                               </select>
                           </div>


                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route('admin.ticket.list')}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-container">
            <table id="">
                <thead>
                    <tr>
                        <th scope="col">
                            @if(check_permission('create_ticket') || check_permission('update_ticket') || check_permission('delete_ticket'))
                                <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                       <th scope="col">
                            {{translate("Ticket Number")}}
                       </th>

                       <th scope="col">
                           {{translate("Subject")}}
                       </th>

                       <th scope="col">
                           {{translate("Status")}}
                       </th>
                       <th scope="col">
                           {{translate("Priority")}}
                       </th>

                       <th scope="col">
                           {{translate("Creation Time")}}
                       </th>

                       <th scope="col">
                           {{translate("Options")}}
                       </th>
                   </tr>

                    </tr>
                </thead>

                <tbody>

                    @forelse($tickets->chunk(site_settings('chunk_value')) as $chunkTickets)
                        @foreach($chunkTickets as $ticket)
                            <tr>
                            <td data-label="#">
                                @if(check_permission('create_ticket') || check_permission('update_ticket') || check_permission('delete_ticket'))
                                    <input type="checkbox" value="{{$ticket->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$ticket->id}}" />
                                @endif
                                {{$loop->iteration}}
                            </td>
                            <td data-label="{{translate("Ticket Number")}}">
                                 <a href="{{route('admin.ticket.show',$ticket->ticket_number)}}">
                                    {{$ticket->ticket_number}}
                                 </a>
                            </td>


                           <td data-label="{{translate("Subject")}}">
                              {{limit_words($ticket->subject,15)}}
                          </td>


                          <td data-label="{{translate("Status")}}">
                            @php echo ticket_status($ticket->status) @endphp

                          </td>

                            <td data-label="{{translate("Priority")}}">
                                @php echo priority_status($ticket->priority) @endphp
                            </td>

                            <td data-label="{{translate("Creation Time")}}">
                                {{get_date_time($ticket->created_at)}}
                            </td>
                             <td data-label="{{translate("Options")}}">
                                <div class="table-action">

                                    <a  href="{{route('admin.ticket.show',[$ticket->ticket_number])}}"  class="icon-btn success"><i class="las la-eye"></i></a>
                                    @if(check_permission('delete_ticket') )
                                        @if(check_permission('delete_ticket'))
                                            @if(request()->routeIs('admin.ticket.list'))
                                                <form action="{{route('admin.ticket.destroy',$ticket->id)}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class="pointer icon-btn danger"><i class="las la-trash-alt"></i></button>
                                                </form>
                                            @else
                                                <form action="{{route('admin.ticket.force.destroy',$ticket->id)}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class=" pointer icon-btn danger" id="deleteModal"><i class="las la-trash-alt"></i></button>
                                                </form>
                                                <form action="{{route('admin.ticket.restore',$ticket->id)}}" method="post" enctype="multipart/form-data">
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

                        <tr class="border-bottom-0">
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
                {{ $tickets->links() }}
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
@push('script-push')
<script>
	(function($){

        $(".select2").select2({
            placeholder:"{{translate('Select Status')}}",
        })

	})(jQuery);
</script>
@endpush
