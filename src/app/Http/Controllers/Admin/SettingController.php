<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Requests\Admin\LogoSettingRequest;
use App\Http\Requests\Admin\RegistrationSettingRequest;
use App\Http\Requests\Admin\TicketSettingRequest;
use App\Http\Services\SettingService;
use App\Models\Core\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Arr;

class SettingController extends Controller
{

    protected $settingService;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_settings'])->only(['index','systemConfiguration']);
        $this->middleware(['permissions:update_settings'])->only(['pluginSetting','create','systemInfo']);

        $this->settingService = new SettingService();
    }

    /**
     * get all system settings
     * @return View
     */
    public function index() :View
    {
        return view('admin.setting.index',[
            'title' => 'Basic Settings',
            'breadcrumbs' =>  ['home'=>'admin.home','Settings'=> null],
            'timeZones' => timezone_identifiers_list(),
            'countries' => json_decode(file_get_contents(resource_path(config('constants.options.country_code')) . 'countries.json'),true)
        ]);
    }

    /**
     * get all system systemConfiguration
     * @return View
     */
    public function systemConfiguration() :View
    {
        return view('admin.setting.system_configuration',[
            'title' => 'System Configuration',
            'breadcrumbs' =>  ['home'=>'admin.home','Configuration'=> null],
        ]);
    }


    /**
     * update pluging settings
     * @return RedirectResponse
     */
    public function pluginSetting(Request $request) :string{

        $status = true;
        $message = translate('Updated Successfully');
        try {
            $this->settingService->updateSettings($request->site_settings);
            if(isset($request->site_settings['google_recaptcha'])){
                if($request->site_settings['google_recaptcha']['status'] == (StatusEnum::true)->status()){
                    Setting::where('key','default_recaptcha')->update(
                        [
                            'value' => (StatusEnum::false)->status()
                        ]
                    );
     
                }
            }
        }catch (\Exception $exception) {
            $status = false;
            $message = $exception->getMessage();
        }
        optimize_clear();
        return json_encode([
            'status' => $status,
            'message' => $message
        ]);
         
    }

   
    /**
     * ticket settings
     *
     * @param TicketSettingRequest $request
     * @return string
     */
    public function ticketSetting(TicketSettingRequest $request) :string{

        $response = $this->settingService->ticketSettings($request);
        optimize_clear();
        return json_encode([
            'status' => Arr::get($response,'status',false),
            'message' =>  Arr::get($response,'message',Arr::get(config('server_error'),'server_error',''))
        ]);
         
    }


    /**
     * Registration setting
     *
     * @param RegistrationSettingRequest $request
     * @return string
     */
    public function registerSetting(RegistrationSettingRequest $request) :string{

        $response = $this->settingService->registrationSettings($request);
        optimize_clear();
        return json_encode([
            'status' => Arr::get($response,'status',false),
            'message' =>  Arr::get($response,'message',Arr::get(config('server_error'),'server_error',''))
        ]);
         
    }

  
     /**
      * update logo settings
      *
      * @param LogoSettingRequest $request
      * @return string
      */
    public function logoSetting(LogoSettingRequest $request) :string{

        $this->settingService->logoSettings($request->except('_token'));
        optimize_clear();
        return json_encode([
            'status'=> true,
            'message'=> translate('Updated Successfully')
        ]);


    }

    /**
     * update  settings
     * @return RedirectResponse
     */
    public function store(Request $request) :string
    {

        $status = true;
        $message = translate('Updated Successfully');
        if($request->site_settings){
            try {
                $validations = $this->settingService->validationRules($request->site_settings);

                $request->validate( $validations['rules'],$validations['message']);
                if(isset($request->site_settings['time_zone'])){
                    $timeLocationFile = config_path('timesetup.php');
                    $time = '<?php $timelog = '.$request->site_settings['time_zone'].' ?>';
                    file_put_contents($timeLocationFile, $time);
                }
                $this->settingService->updateSettings($request->site_settings);
              
            } catch (\Exception $exception) {
               $status = false;
               $message = $exception->getMessage();
            }
        }
    
        optimize_clear();

        return json_encode([
            'status' => $status,
            'message' => $message
        ]);

    }


  
    /**
     * clear cache
     * @return RedirectResponse
     */
    public function cacheClear() :RedirectResponse
    {
        optimize_clear();
        return back()->with(response_status('Cache Cleared Successfully'));
    }

    /**
     * clear cache
     * @return View
     */
    public function systemInfo() :View
    {
        $systemInfo = [
            'laravel_version' => app()->version(),
            'server_detail' => $_SERVER,
            'php_version' => phpversion(),
        ];
        return view('admin.system_info',[
            'breadcrumbs' =>  ['home'=>'admin.home','SystemInfo'=> null],
            'title' => "System Information",
            'systemInfo' =>  $systemInfo
        ]);
    }

   

    /**
     * update setting status
     * @return JsonResponse
     */
    public function updateStatus(Request $request) : JsonResponse{
        $response = $this->settingService->statusUpdate($request);
        optimize_clear();
        return response()->json($response);
    }
}
