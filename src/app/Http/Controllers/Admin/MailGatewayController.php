<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GatewayRequest;
use App\Http\Utility\SendMail;
use App\Models\Admin\MailGateway;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MailGatewayController extends Controller
{
    /**
     *
     * @return void
     */
    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_gateway'])->only('index');
        $this->middleware(['permissions:update_gateway'])->only(['edit','update','updateStatus']);
    }


    /**
     * gateway list
     *
     * @return View
     */
    public function index() :View{

        return view('admin.mail_gateway.index',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Gateway'=> null],
            'title' => 'Manage Gateway',
            'gateways' => MailGateway::filter()->with(['createdBy','updatedBy'])->latest()->get()
        ]);
    }


    /**
     * edit gateway
     *
     * @return View
     */
    public function edit(int | string $uid) :View{

        $gateway = MailGateway::where('uid',$uid)->where('code',"!=","104PHP")->firstOrFail();

        return view('admin.mail_gateway.edit',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Gateway'=> "admin.mailGateway.list","Edit" => null],
            'title' => 'Update '.$gateway->name,
            'gateway' => $gateway
        ]);
    }

    /**
     * update gateway
     *
     * @param GatewayRequest $request
     * @return RedirectResponse
     */
    public function update(GatewayRequest $request) :RedirectResponse{

        $gateway = MailGateway::where('id',$request->id)->first();
        $gateway->credential = $request->input("credential");
        $gateway->save();
        return  back()->with(response_status('Updated Successfully'));
    }



    /**
     * test gateway
     *
     * @return RedirectResponse
     */
    public function test(Request $request) :RedirectResponse{

        $request->validate(
            [
                "id" => ["required",'exists:mail_gateways,id'],
                "email" => ["required",'email']
            ]);
        $gateway = MailGateway::where('id',$request->id)->firstOrFail();
        $code = [
            'time' =>  get_date_time(Carbon::now())
        ];

        $response = SendMail::mailNotifications("TEST_MAIL",$code , (object) ["name" =>"dear", 'email'=>$request->get('email')] , $gateway);
        return  back()->with(response_status((preg_replace('/[^a-zA-Z0-9@._\- ]/', '', $response['message'])), $response['status'] ? "success" :"error"));
    }

    /**
     * Update a specific gateway status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:mail_gateways,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);

        $response['message'] = translate('Failed To Update !!');
        $response['status'] = false;

        if($request->data['status'] == StatusEnum::true->status()){

            MailGateway::where('uid',$request->data['id'])->update([
                'default' => $request->data['status'],
                'updated_by' => auth_user()->id
            ]);

            MailGateway::where('uid',"!=",$request->data['id'])->update([
                'default' =>  StatusEnum::false->status()  ,
                'updated_by' => auth_user()->id
            ]);
            $response['status'] = true;
            $response['message'] = translate('Updated Successfully');
        }

        $response['reload'] = true;

        return json_encode($response);
    }
}
