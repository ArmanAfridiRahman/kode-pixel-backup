<?php
namespace App\Http\Services;

use App\Models\Admin\Portfolio;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PortfolioService
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
     * store portfolio
     *
     * @param Request $request
     * @return Portfolio
     */
    public function save(Request $request) :Portfolio{
       
        $portfolio = new Portfolio();
        $portfolio->created_by = auth_user()->id;
        $portfolio->title = $request->get('title');
        $portfolio->short_description = $request->get('short_description');
        $portfolio->url = $request->get('url');
        $portfolio->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['portfolio_method']['path'],config("settings")['file_path']['portfolio_method']['size']);
            if($response['status']){
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $portfolio->file()->save($image);
            }
        }
        return $portfolio;
    }
     /**
     * update portfolio
     *
     * @param Request $request
     * @return Portfolio
     */
    public function update(Request $request) :Portfolio{
        
        $portfolio = Portfolio::with(['createdBy'])->where('id', $request->get('id'))->firstOrFail();
        $portfolio->updated_by = auth_user()->id;
        $portfolio->title = $request->get('title');
        $portfolio->short_description = $request->get('short_description');
        $portfolio->url = $request->get('url');
        $portfolio->save();
        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['portfolio_method']['path'],config("settings")['file_path']['portfolio_method']['size'],@$portfolio->file->name);
            if($response['status']){
                $portfolio->file()->delete();
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $portfolio->file()->save($image);
            }
        }

        return $portfolio;
    }
    /**
     * Portfolio bulk action
     *
     * @param Request $request
     * @return array
     */

    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated portfolios status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Portfolio::with(['file'])->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        
        else{
            $response =  response_status('Portfolios have been successfully deleted.');
            $portfolios = Portfolio::with(['file'])->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($portfolios as $portfolioChunks){
                foreach($portfolioChunks as $portfolio)
                $this->delete($portfolio->uid);
            }
        }
        return $response;

    }

    public function delete($uid){
        $portfolio = Portfolio::where('uid',$uid)->firstOrFail();
        $portfolio->delete();
    }
}
