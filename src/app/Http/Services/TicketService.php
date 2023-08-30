<?php
namespace App\Http\Services;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Utility\SendNotification;
use App\Models\Core\File;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TicketService
{

    private $fileService;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->fileService = new FileService();

    }

    /**
     * Create A Ticket
     *
     * @param array $request
     * @return Ticket
     */
    public function store(array $request) :Ticket{


        $ticket = new Ticket();
        $ticket->ticket_number = generateTicketNumber();
        $ticket->user_id = auth_user("web")->id;
        $ticket->subject = Arr::get($request['ticket_data'],'subject' ,'');
        $ticket->message = Arr::get($request['ticket_data'],'description' ,'');
        $ticket->priority = Arr::get($request,'priority' ,1);
        $ticket->status = TicketStatus::PENDING;

        $ticket->ticket_data =  (Arr::except($request['ticket_data'],['attachment']));

        $ticket->save();

        if(isset($request["ticket_data"] ['attachment'][0])){
            foreach($request["ticket_data"] ['attachment'] as $file){
                $response = $this->fileService->storeFile($file, config("settings")['file_path']['ticket']['path']);
                if($response['status']){
                    $file = new File();
                    $file->name =  Arr::get( $response ,'name',"#");
                    $file->disk =  Arr::get( $response ,'disk',"local");
                    $file->type =  "ticket_file";
                    $ticket->files()->save($file);
                }
            }
        }

        $message = $this->ticketMessage($ticket);
        if(site_settings('database_notifications') == StatusEnum::true->status()){
            $code = [
                "message" =>   auth_user("web")->name ." Just Create A ",
                "url" => route('admin.ticket.reply',$ticket->ticket_number)
            ];
            SendNotification::database_notifications($code);
        }

        return  $ticket;

    }

    /**
     * store ticket message
     *
     * @param Ticket $ticket
     * @return Message
     */
    public function ticketMessage(Ticket $ticket) :Message{

        $message = new Message();
        $message->ticket_id = $ticket->id;
        $message->message = $ticket->message;
        $message->save();
        return $message;
    }


    public function download(Request $request) : mixed {
        $file = File::where('id',$request->id)->firstOrFail();
        if($file){
            return $this->fileService->downloadFile(config("settings")['file_path']['ticket']['path'],$file->name ,$file->disk);
        }
        return false;
    }
    /**
     * Ticket bulk action
     *
     * @param Request $request
     * @return array
     */
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated tickets status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){
            Ticket::whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }

        else{
            $response =  response_status('Tickets has been successfully deleted.');
            $tickets = Ticket::whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));
            foreach($tickets as $ticketChunks){
                foreach ($ticketChunks as $ticket)
                $this->delete($ticket->uid);
            }
        }
        return $response;

    }
    public function delete($uid){
        $ticket = Ticket::where('uid',$uid)->firstOrFail();
        $ticket->delete();

    }

}
