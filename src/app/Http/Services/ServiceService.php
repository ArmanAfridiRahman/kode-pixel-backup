<?php
namespace App\Http\Services;

use App\Models\Admin\Service;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ServiceService
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
     * store service
     *
     * @param Request $request
     * @return Service
     */
    public function save(Request $request) :Service{
       
        $service = new Service();
        $service->created_by = auth_user()->id;
        $service->title = $request->get('title');
        $service->short_description = $request->get('short_description');
        $service->long_description = $request->get('long_description');
        $parameter = [];
        if ($request->has('service_name') ) {
            for ($i = 0; $i < count($request->get('service_name')); $i++) {
                $serviceArray = array();
                $serviceArray['service_name'] = format_str($request->service_name[$i]);
                $serviceArray['field_label'] = $request->service_name[$i];
                $parameter[$serviceArray['service_name']] = $serviceArray;
            }
        }
       
        $service->parameters = $parameter;
        $service->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['service_method']['path'],config("settings")['file_path']['service_method']['size']);
            if($response['status']){
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $service->file()->save($image);
            }
        }
        return $service;
    }
     /**
     * update service
     *
     * @param Request $request
     * @return Service
     */
    public function update(Request $request) :Service{
        $service = Service::with(['createdBy'])->where('id', $request->get('id'))->firstOrFail();
        $service->updated_by = auth_user()->id;
        $service->title = $request->get('title');
        $service->short_description = $request->get('short_description');
        $service->long_description = $request->get('long_description');
        $parameter = [];
        if ($request->has('service_name') ) {

            for ($i = 0; $i < count($request->get('service_name')); $i++) {
                $arr = array();
                $arr['service_name'] = format_str($request->service_name[$i]);
                $arr['field_label'] = $request->service_name[$i];
                $parameter[$arr['service_name']] = $arr;
            }
        }
        $service->parameters = ($parameter);
        $service->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['service_method']['path'],config("settings")['file_path']['service_method']['size'],@$service->file->name);
            if($response['status']){
                $service->file()->delete();
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $service->file()->save($image);
            }
        }

        return $service;
    }
    /**
     * Service bulk action
     *
     * @param Request $request
     * @return array
     */

    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated services status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Service::with(['file'])->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        
        else{
            $response =  response_status('Services have been successfully deleted.');
            $services = Service::with(['file'])->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($services as $serviceChunks){
                foreach($serviceChunks as $service)
                $this->delete($service->uid);
            }
        }
        return $response;

    }

    public function delete($uid){
        $service = Service::where('uid',$uid)->firstOrFail();
        $service->delete();
    }
}
