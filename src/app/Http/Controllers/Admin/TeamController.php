<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamRequest;
use App\Http\Services\FileService;
use App\Models\Admin\Team;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Http\Services\TeamService;
use Illuminate\Validation\Rule;


class TeamController extends Controller
{
    private $fileService, $teamService;

    public function __construct(){
        $this->fileService = new FileService();
        $this->teamService = new TeamService();
        $this->middleware(['permissions:view_team'])->only('index');
        $this->middleware(['permissions:create_team'])->only('create');
        $this->middleware(['permissions:update_team'])->only('edit', 'update');
        $this->middleware(['permissions:delete_team'])->only('destroy');
    }

    public function index(Request $request) :View{
        return view('admin.team.index', [
            'title' => 'Team List',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Team' => 'admin.team.list'],
            'teams' => Team::with(['createdBy', 'updatedBy'])->filter($request)->latest()->get()                                       
        ]);
    }

    public function create() :View{
        return view('admin.team.create', [
            'title' => 'Team',
            'breadcrumbs' =>  ['Dashboard' => 'admin.home', 'Team' => 'admin.team.list', 'Create' => null],
        ]);
    }

    public function edit(int | string $uid) :View{
        return view('admin.team.edit', [
            'title' => 'Team',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Team' => 'admin.team.list'],
            'team' => Team::where('uid', $uid)->first(),
        ]);
    }

    public function store(TeamRequest $request) :RedirectResponse{
        $team = $this->teamService->save($request);
        return redirect()->route('admin.team.list')->with(response_status('Updated Successfully'));
    }


    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:teams,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);
        Team::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfuly');
        return json_encode($response);
    }

    public function update(TeamRequest $request) :RedirectResponse{
        $team = $this->teamService->update($request);
        return redirect()->route('admin.team.list')->with(response_status('Updated Successfully'));
    }

    public function destroy($uid) :RedirectResponse{

        $response = response_status('Team Not Found', 'error');
        $team = Team::where('uid', $uid)->firstOrFail();

        if($team){
            $response =  response_status('Team Deleted');
            $this->fileService->unlink( config("settings")['file_path']['team_method']['path'],@$team->file->name);
            $team->file()->delete();
            $team->delete();
        }
        return back()->with($response);
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
            'bulk_id.*' => ['exists:teams,id'],
            'type' => ['required', Rule::in(['status', 'delete'])],
            'value' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('type') === 'status';
                }),

                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'status' && !in_array($value, StatusEnum::toArray())) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ],
        ];
        $request->validate($rules);
        $response = $this->teamService->bulktAction( $request);
        return  back()->with($response);
    }
}
