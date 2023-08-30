<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\FileService;
use App\Http\Services\TicketService;
use App\Http\Utility\SendNotification;
use App\Models\Core\File;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TicketController extends Controller
{


    protected $ticketService ,$fileService;

    public function __construct(){

        $this->ticketService = new TicketService();
        $this->fileService = new FileService();
        $this->middleware(['permissions:view_ticket'])->only('list','show','reply','download','update');
        $this->middleware(['permissions:delete_ticket'])->only('destroyFile','destroy',"destroyMessage");
    }

    /**
     * Support Ticket View
     *
     * @return View
     */
    public function list() :View{

        return view('admin.ticket.list',[

            "title" => translate("Ticket List"),
            'breadcrumbs' =>  ['Home'=>'admin.home','Tickets'=> null],
            'tickets' => Ticket::filter()->with(['messages'])
            ->latest()
            ->paginate(paginateNumber()),
            'counter' => $this->counter()

        ]);
    }


    /**
     * count ticket data
     */

     public function counter() :array{

        $counter = array();
        $counter['pending'] = Ticket::filter()->pending()->count();
        $counter['solved'] = Ticket::filter()->solved()->count();
        $counter['closed'] = Ticket::filter()->closed()->count();
        $counter['hold'] = Ticket::filter()->hold()->count();
        return $counter;

     }



    /**
     * Support Ticket View
     *
     * @return View
     */
    public function show(string $ticketNumber) :View{

        return view('admin.ticket.show',[
            "title" => translate("Ticket Details"),
            'breadcrumbs' =>  ['Home'=>'admin.home','Tickets'=> "admin.ticket.list" ,"Reply" => null],
            'meta_data'=> $this->metaData(["title" => translate("Ticket Details")]),
            'ticket' => Ticket::with(['user','messages','messages.admin' ,'messages.admin.file'])
            ->where("ticket_number",$ticketNumber)
            ->latest()
            ->firstOrFail()
        ]);
    }



    /**
     * Reply Ticket
     *
     * @return RedirectResponse
     */
    public function reply(Request $request) :RedirectResponse{

        $request->validate([
            'id' => "required|exists:tickets,id",
            "message" => 'required'
        ]);

        $ticket = Ticket::where('id',$request->get('id'))->firstOrFail();
        $message = new Message();
        $message->admin_id = auth_user()->id;
        $message->ticket_id = $request->get('id');
        $message->message = $request->get("message");
        $message->save();

        if(site_settings('database_notifications') == StatusEnum::true->status()){
            $code = [
                "message" =>   auth_user()->name ." Just Replied To A Ticket",
                "url" => route('user.ticket.show',$ticket->ticket_number),
                'user_id' => $ticket->user_id
            ];
            SendNotification::database_notifications($code);
        }


        return back()->with(response_status('Replied Successfully'));
    }


    /**
     * download a file
     */
    public function download(Request $request) :mixed {

        $request->validate([
            'id'=>'required|exists:files,id',
        ]);

        $url =  $this->ticketService->download($request);
        if(!$url){
            return back()->with('error',translate('File Not Found'));
        }
        return $url;
    }




    /**
     * destroy a ticket
     */
    public function destroy(string $id) :RedirectResponse {

        $ticket = Ticket::with(['messages','file'])->where('id',$id)->firstOrFail();
        $ticket->messages()->delete();
        try {
            $files = $ticket->file;
            foreach($files as $file){
                $file->delete();
            }
        } catch (\Throwable $th) {

        }

        $ticket->delete();

        return back()->with(response_status('Ticket Deleted Successfully'));

    }


    /**
     * Destroy Message
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroyMessage(string $id) :RedirectResponse {

        $message = Message::where('id',$id)->firstOrFail();
        $message->delete();
        return back()->with(response_status('Message Deleted Successfully'));
    }


    /**
     * Update Ticket Status
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            "id"=>"required|exists:tickets,id",
            "key"=>"required",
            'status' => "required"
        ]);

        $ticket = Ticket::with(['messages','file]'])->where('id',$request->get("id"))->update([
            $request->get("key") => $request->get("status")
        ]);

        $responseStatus  =  response_status('Filed To Update','error');
        if($ticket){
            $responseStatus  =  response_status('Status Updated');
        }

        return back()->with($responseStatus );
    }



    /**
     * destroy a file
     */
    public function destroyFile(string $id) :RedirectResponse {

        $file = File::where('id',$id)->firstOrFail();

        try {
            $this->fileService->unlink(config("settings")['file_path']['ticket']['path'] ,@$file->name );
            $file->delete();
        } catch (\Throwable $th) {
            return back()->with('error',translate('File Not Found'));
        }

        return back()->with('success',translate('File Deleted'));
    }

    /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulk(Request $request) :RedirectResponse {

        $bulkIds = json_decode($request->input('bulk_id'), true);
        $request->merge([
            "bulk_id" =>  $bulkIds
        ]);

        $rules = [
            'bulk_id' => ['array', 'required'],
            'bulk_id.*' => ['exists:tickets,id'],
            'type' => ['required', Rule::in(['status', 'delete'])],
            'value' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('type') === 'status';
                }),

                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'status' && !in_array($value, TicketStatus::toArray())) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ],
        ];

        $request->validate($rules);
        $response = $this->ticketService->bulktAction( $request);

        return  back()->with($response);
    }

}
