<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Services\FileService;
use App\Models\Admin\Product;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Http\Services\ProductService;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private $fileService, $productService;

    public function __construct(){
        $this->fileService = new FileService();
        $this->productService = new ProductService();
        $this->middleware(['permissions:view_product'])->only('index');
        $this->middleware(['permissions:create_product'])->only('create');
        $this->middleware(['permissions:update_product'])->only('edit', 'update');
        $this->middleware(['permissions:delete_product'])->only('destroy');
    }

    public function index(Request $request) :View {
        
        return view('admin.product.index', [
            'title' => 'Product List',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Product' => 'admin.product.list'],
            'products' => Product::with(['createdBy', 'updatedBy'])->filter($request)->latest()->get()      //remove create by and update by from eveery table                                 
        ]);
    }

    public function create() :View{
        return view('admin.product.create', [
            'title' => 'Product',
            'breadcrumbs' =>  ['Dashboard' => 'admin.home', 'Product' => 'admin.product.list', 'Create' => null],
        ]);
    }

    public function edit(int | string $uid) :View{
        return view('admin.product.edit', [
            'title' => 'Product',
            'breadcrumbs' => ['Dashboard' => 'admin.home', 'Product' => 'admin.product.list'],
            'product' => Product::where('uid', $uid)->first(),
        ]);
    }

    public function store(ProductRequest $request) :RedirectResponse{
        $product = $this->productService->save($request);
        return redirect()->route('admin.product.list')->with(response_status('Updated Successfully'));
    }


    public function updateStatus(Request $request) :string{

        $request->validate([
            'data.id'=>'required|exists:products,uid',
            'data.status'=> ['required',Rule::in(StatusEnum::toArray())]
        ]);
        Product::where('uid',$request->data['id'])->update([
            'status' => $request->data['status'],
            'updated_by' => auth_user()->id
        ]);

        $response['reload'] = true;
        $response['status'] = true;
        $response['message'] = translate('Updated Successfuly');
        return json_encode($response);
    }

    public function update(ProductRequest $request) :RedirectResponse{
        $product = $this->productService->update($request);
        return redirect()->route('admin.product.list')->with(response_status('Updated Successfully'));
    }

    public function destroy($uid) :RedirectResponse{

        $response = response_status('Product Not Found', 'error');
        $product = Product::where('uid', $uid)->firstOrFail();

        if($product){
            $response =  response_status('Product Deleted');
            $this->fileService->unlink( config("settings")['file_path']['product_method']['path'],@$product->file->name);
            $product->file()->delete();
            $product->delete();
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
            'bulk_id.*' => ['exists:products,id'],
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
        $response = $this->productService->bulktAction( $request);
        return  back()->with($response);
    }
}
