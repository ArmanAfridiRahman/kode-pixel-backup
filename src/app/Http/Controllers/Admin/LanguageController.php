<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\LanguageRequest;
use App\Http\Services\LanguageService;
use App\Models\Core\Language;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public $languageService;

    /**
     * Constructs a new instance of the LanguageService class.
     *
     * @return void
     */

    public function __construct()
    {
        $this->languageService = new LanguageService();

        //check permissions middleware
        $this->middleware(['permissions:view_language'])->only('index');
        $this->middleware(['permissions:create_language'])->only('store');
        $this->middleware(['permissions:update_language'])->only(['setDefaultLang','updateStatus','updateDirection']);
        $this->middleware(['permissions:translate_language'])->only(['translate','tranlateKey']);
        $this->middleware(['permissions:delete_language'])->only(['destroyTranslateKey','destroy']);
    }


    /**
     * Display the language management page.
     *
     * @return \Illuminate\View\View
     */
    public function index() :\Illuminate\View\View
    {

        return view('admin.language.index', [
            'title' =>  translate("Manage Language"),
            'breadcrumbs' =>  ['home'=>'admin.home','language'=> null],
            'languages' =>   $this->languageService->index(),
            'countryCodes' => json_decode(file_get_contents(resource_path(config('constants.options.country_code')) . 'countries.json'),true)
        ]);
    }

    /**
     * Store a new language.
     *
     * @param LanguageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LanguageRequest $request) :\Illuminate\Http\RedirectResponse
    {
        $response = $this->languageService->store($request);
        return back()->with($response['status'],$response['message']);
    }

    /**
     * Make a language as default
     *
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultLang(int | string $id) :\Illuminate\Http\RedirectResponse {

        $response = $this->languageService->setDefault($id);
        return back()->with($response['status'],$response['message']);
    }

    /**
     * Updates the status of a language.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\string
     */
    public function updateStatus(Request $request) :string{

        $response['reload'] = true;
        $response['status'] = false;
        $response['message'] = translate('Failed To Update');
        try {
            $request->validate([
                'data.id'=>'required|exists:languages,uid',
                'data.status'=> ['required',  Rule::in(StatusEnum::toArray())]
            ],[
                'data.id.required'=>translate('The Id Field Is Required')
            ]);
            $language = Language::where('uid',$request->data['id'])->first();
            $response['reload'] = true;
            $response['status'] = true;
            $response['message'] = translate('Updated Successfully');
            if(session()->get('locale') == $language->code){
                $response['status'] = false;
                $response['message'] = translate('System Current Language Status Can not be Updated');
            }
            else{
                if($language->is_default == (StatusEnum::true)->status()){
                    $response['status'] = false;
                    $response['message'] = translate('You Can not Update Default language Status');
                }
                else{
                    $language->status = $request->data['status'];
                    $language->updated_by = auth_user('admin')->id;
                    $language->save();

                }
            }

        } catch (\Throwable $th) {

        }
        return json_encode($response);

    }


    /**
     * Updates the status of a language.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\string
     */
    public function updateDirection(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:languages,uid',
            'data.status'=> ['required',  Rule::in(StatusEnum::toArray())]
        ],[
            'data.id.required'=>translate('The Id Field Is Required')
        ]);
        $language = Language::where('uid',$request->data['id'])->first();
        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfully');

        if(session()->get('locale') == $language->code){
            $response['status'] = false;
            $response['message'] = translate('System Current Language Status Can not be Updated');
        }
        else{
            $language->ltr = $request->data['status'];
            $language->updated_by = auth_user('admin')->id;
            $language->save();
        }
        return json_encode($response);
    }



    /**
     * Display the language translation page.
     *
     * @param  string $code
     * @return \Illuminate\View\View
     */
    public function translate(string $code) :\Illuminate\View\View{

        return view('admin.language.translate', [
            'title' =>  translate("Translate language"),
            'breadcrumbs' =>  ['home'=>'admin.home','language'=> 'admin.language.list' ,"translate"=> null],
            'translations'=>  $this->languageService->translationVal($code)
        ]);
    }

    /**
     * Translate a specific lang key.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\string
     */
    public function tranlateKey(Request $request) :string{

        $response = $this->languageService->translateLang($request);
        return json_encode([
            "success" => $response
        ]);
    }

    /**
     * Destroy A language
     *
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int | string $id) :\Illuminate\Http\RedirectResponse {
        $response = $this->languageService->destory($id);
        return back()->with( $response['status'],$response['message']);
    }
    public function forceDestroy($id) :RedirectResponse{

        $response = response_status('Language Not Found', 'error');
        $language = Language::onlyTrashed()->where('id', $id)->firstOrFail();
        if($language->trashed()){
            $response =  response_status('Language Deleted');
            $language->forceDelete();
        }
        return back()->with($response);
    }

    public function restore($id) :RedirectResponse{
        $language = Language::onlyTrashed()->where('id', $id)->firstOrFail();
        $language->restore();
        $response =  response_status('Language Restored');
        return redirect()->route('admin.language.archive')->with($response);
    }

    /**
     * Destroy A language transaltion
     *
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyTranslateKey(int | string $id) :\Illuminate\Http\RedirectResponse {
        $response = $this->languageService->destoryKey($id);
        return back()->with( $response['status'],$response['message']);
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
            'bulk_id.*' => ['exists:languages,id'],
            'type' => ['required', Rule::in(['status', 'delete', 'restore'])],
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
        $response = $this->languageService->bulktAction( $request);
        return  back()->with($response);
    }
}
