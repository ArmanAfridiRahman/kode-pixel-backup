<?php
namespace App\Http\Services;

use App\Enums\StatusEnum;
use App\Models\Core\Language;
use App\Models\Core\Translation;
use Illuminate\Http\Request;
use App\Models\Core\File;

class LanguageService
{

    public function index()
    {

        return request()->routeIs('admin.language.list') ?
        Language::with(['updatedBy','createdBy'])->latest()->get():
        Language::onlyTrashed()->with(['updatedBy','createdBy'])->latest()->get();

    }

    public function store($request) :array
    {

        $country  =  explode("//", $request->name);
        $code = $request->code?$request->code:  strtolower($country[1]);
        if(Language::where('code',$code)->exists()){
            $response['status'] = "error";
            $response['message'] = translate('This Language Is Already Added !! Try Another');
        }
        else{
            $language = Language::create([
                'name' => $country[0],
                'code' => $code,
                'created_by' => auth_user()->id,
                'is_default'=> (StatusEnum::false)->status(),
                'status'=> (StatusEnum::true)->status(),
            ]);

            try {
                $translations = Translation::where('code', 'en')->get();
                $translationsToCreate = [];

                foreach ($translations as $k) {
                    $translationsToCreate[] = [
                        "uid"=> str_unique(),
                        'code' => $language->code,
                        'key' => $k->key,
                        'value' => $k->value
                    ];
                }

                Translation::insert($translationsToCreate);


            } catch (\Throwable $th) {
                //throw $th;
            }

            $response['status'] = "success";
            $response['message'] = translate('Language Created Succesfully');
            $response['data'] = $language;
        }
        return $response;
    }


    public function translationVal(string $code)
    {
        return Translation::where('code',$code)->paginate(paginateNumber());
    }

    public function translateLang($request) :bool{

        $response = true;
        try {
            Translation::where('id',$request->data['id'])->update([
                'value' => $request->data['value']
            ]);
            optimize_clear();
        } catch (\Throwable $th) {
            $response = false;
        }

        return $response;

    }

    public function setDefault(int | string $uid) :array{
        $response['status'] = "success";
        $response['message'] = translate('Default Language Set Successfully');

        Language::where('uid','!=',$uid)->update([
          'is_default' => (StatusEnum::false)->status(),
          "updated_by" => auth_user('admin')->id
        ]);
        Language::where('uid',$uid)->update([
          'is_default'=>(StatusEnum::true)->status(),
        ]);
        return $response;
    }



    public function destory(int | string $uid) :array
    {
        $response['status'] = 'success';
        $response['message'] = translate('Deleted Successfully');
        try {
            $language = Language::where('uid',$uid)->first();
            if( $language->code == 'en' || $language->is_default == StatusEnum::true){
                $response['code'] = "error";
                $response['message'] = translate('Default & English Language Can Not Be Deleted');
            }
            else{
                Translation::where("code",$language->code)->delete();
                $language->delete();
            }

        } catch (\Throwable $th) {
            $response['status'] = 'error';
            $response['message'] = translate('Post Data Error !! Can Not Be Deleted');
        }
        return $response;
    }

    public function destoryKey(int | string $id):array
    {
        $response['status'] = 'success';
        $response['message'] = translate('Key Deleted Successfully');
        try {
            $transData = Translation::where('uid',$id)->first();
            $transData->delete();
            optimize_clear();

        } catch (\Throwable $th) {
            $response['status'] = 'error';
            $response['message'] = translate('Post Data Error !! Can Not Be Deleted');
        }
        return $response;
    }
    /**
     * Language bulk action
     *
     * @param Request $request
     * @return array
     */
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated languages status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){
            Language::withTrashed()->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        elseif($request->get("type") == 'restore'){
            $response =  response_status('Languages have been successfully Restored.');
            $languages = Language::withTrashed()->whereIn('id',$bulkIds)->get();
            foreach($languages as $language){
                $this->restore($language->uid);
            }
        }
        else{
            $response =  response_status('Languages have been successfully deleted.');
            $languages = Language::withTrashed()->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));
            foreach($languages as $languageChunks){
                foreach ($languageChunks as $language){
                    $this->delete($language->uid);
                }

            }
        }
        return $response;

    }

    public function restore($uid){
        $language = Language::withTrashed()->where('uid',$uid)->firstOrFail();
        $language->restore();
    }

    public function delete($uid){
        $language = Language::withTrashed()->where('uid',$uid)->firstOrFail();
        if ($language->trashed()){
            $language->forceDelete();
        }
        else{
            $language->delete();
        }
    }
}
