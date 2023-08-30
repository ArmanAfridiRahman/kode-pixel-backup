<?php
namespace App\Http\Services;

use App\Models\Admin\Process;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProcessService
{


    /**
     * store process
     *
     * @param Request $request
     * @return Process
     */
    public function save(Request $request) :Process{
       
        $process = new Process();
        $process->created_by = auth_user()->id;
        $process->title = $request->get('title');
        $process->short_description = $request->get('short_description');
        $process->icon = $request->get('icon');
       
        $process->save();

      
        return $process;
    }
     /**
     * update process
     *
     * @param Request $request
     * @return Process
     */
    public function update(Request $request) :Process{
        $process = Process::with(['createdBy'])->where('id', $request->get('id'))->firstOrFail();
        $process->updated_by = auth_user()->id;
        $process->title = $request->get('title');
        $process->short_description = $request->get('short_description');
        $process->icon = $request->get('icon');
       
        $process->save();

        return $process;
    }
    
    /**
     * Process bulk action
     *
     * @param Request $request
     * @return array
     */

    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated processs status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Process::with(['file'])->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        
        else{
            $response =  response_status('Processs have been successfully deleted.');
            $processs = Process::with(['file'])->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($processs as $processChunks){
                foreach($processChunks as $process)
                $this->delete($process->uid);
            }
        }
        return $response;

    }

    public function delete($uid){
        $process = Process::where('uid',$uid)->firstOrFail();
        $process->delete();
    }
}
