<?php
namespace App\Http\Services;

use App\Models\Admin\Team;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TeamService
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
     * store team
     *
     * @param Request $request
     * @return Team
     */
    public function save(Request $request) :Team{
       
        $team = new Team();
        $team->created_by = auth_user()->id;
        $team->name = $request->get('name');
        $team->designation = $request->get('designation');
        $team->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['team_method']['path'],config("settings")['file_path']['team_method']['size']);
            if($response['status']){
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $team->file()->save($image);
            }
        }
        return $team;
    }
     /**
     * update team
     *
     * @param Request $request
     * @return Team
     */
    public function update(Request $request) :Team{
        
        $team = Team::with(['createdBy'])->where('id', $request->get('id'))->firstOrFail();
        $team->updated_by = auth_user()->id;
        $team->name = $request->get('name');
        $team->designation = $request->get('designation');
        $team->save();
        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['team_method']['path'],config("settings")['file_path']['team_method']['size'],@$team->file->name);
            if($response['status']){
                $team->file()->delete();
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $team->file()->save($image);
            }
        }

        return $team;
    }
    /**
     * Team bulk action
     *
     * @param Request $request
     * @return array
     */

    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated teams status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Team::with(['file'])->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        
        else{
            $response =  response_status('Teams have been successfully deleted.');
            $teams = Team::with(['file'])->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($teams as $teamChunks){
                foreach($teamChunks as $team)
                $this->delete($team->uid);
            }
        }
        return $response;

    }

    public function delete($uid){
        $team = Team::where('uid',$uid)->firstOrFail();
        $team->delete();
    }
}
