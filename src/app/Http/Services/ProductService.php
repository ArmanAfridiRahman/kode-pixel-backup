<?php
namespace App\Http\Services;

use App\Models\Admin\Product;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductService
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
     * store product
     *
     * @param Request $request
     * @return Product
     */
    public function save(Request $request) :Product {
       
        $product = new Product();
        $product->created_by = auth_user()->id;
        $product->rating = $request->get('rating');
        $product->title = $request->get('title');
        $product->short_description = $request->get('short_description');
        $product->message = $request->get('message');
        $product->url = $request->get('url');
        $product->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['product_method']['path'],config("settings")['file_path']['product_method']['size']);
            if($response['status']){
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $product->file()->save($image);
            }
        }
        return $product;
    }
     /**
     * update product
     *
     * @param Request $request
     * @return Product
     */
    public function update(Request $request) :Product{
        
        $product = Product::with(['createdBy'])->where('id', $request->get('id'))->firstOrFail();
        $product->updated_by = auth_user()->id;
        $product->rating = $request->get('rating');
        $product->title = $request->get('title');
        $product->short_description = $request->get('short_description');
        $product->message = $request->get('message');
        $product->url = $request->get('url');
        $product->save();
        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['product_method']['path'],config("settings")['file_path']['product_method']['size'],@$product->file->name);
            if($response['status']){
                $product->file()->delete();
                $image = new File();
                $image->name = Arr::get($response, 'name', '#');
                $image->disk = Arr::get($response, 'disk', 'local');
                $product->file()->save($image);
            }
        }

        return $product;
    }
    /**
     * Product bulk action
     *
     * @param Request $request
     * @return array
     */

    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated products status');
        $bulkIds = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Product::with(['file'])->whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        
        else{
            $response =  response_status('Products have been successfully deleted.');
            $products = Product::with(['file'])->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($products as $productChunks){
                foreach($productChunks as $product)
                $this->delete($product->uid);
            }
        }
        return $response;

    }

    public function delete($uid){
        $product = Product::where('uid',$uid)->firstOrFail();
        $product->delete();
    }
}
