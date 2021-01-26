<?php

namespace App\Http\Controllers\Auth;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Contracts\BrandContract;
use App\Contracts\ProductContract;
use App\Contracts\CategoryContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;
use App\Models\ProductImage;

class ProductController extends BaseController
{
    protected $brandRepository;

    protected $categoryRepository;

    protected $productRepository;

    public function __construct(
        BrandContract $brandRepository,
        CategoryContract $categoryRepository,
        ProductContract $productRepository
    )
    {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        // $products = $this->productRepository->listProducts()->with('category', 'branch');

        $products = Product::with('category', 'branch', 'images')->get();

        return response()->json($products);

    }

    public function select($id)
    {
        // $product = $this->productRepository->findProductById($id);
        $product = Product::with('category', 'branch', 'images')->find($id);
        return response()->json($product);

    }

    public function image($id){

        $images = ProductImage::where('product_id', $id)->get();

        return response()->json($images);
    }

    public function create()
    {
        $brands = $this->brandRepository->listBrands('name', 'asc');
        $categories = $this->categoryRepository->listCategories('name', 'asc');

        return response()->json([
            'brands' => $brands,
            'categories' => $categories
        ]);

    }

    public function store(StoreProductFormRequest $request)
    {

        $params = $request->except('_token');

        $product = $this->productRepository->createProduct($params);

        if (!$product) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json($product);


    }

    public function edit($id)
    {
        // $product = $this->productRepository->findProductById($id);

        $product = Product::with('images', 'branch')->findOrFail($id);

        return response()->json($product);

    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name'              =>  'required',
            'detail_image'      =>  'mimes:jpg,jpeg,png',
            'sku'               =>  'required',
            'branch_id'         =>  'required|not_in:0',
            'categories'        =>  'required|not_in:0',
            'price'             =>  'required|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price'        =>  'regex:/^\d+(\.\d{1,2})?$/',
            'quantity'          =>  'required|integer',
            'weight'            =>  'regex:/^\d+(\.\d{1,2})?$/',
            'width'             =>  'regex:/^\d+(\.\d{1,2})?$/',
            'length'            =>  'regex:/^\d+(\.\d{1,2})?$/',
            'height'            =>  'regex:/^\d+(\.\d{1,2})?$/',
        ]);

        return $request->all();


        $params = $request->except('_token');

        $product = $this->productRepository->updateProduct($params);

        if (!$product) {
            return response()->json([
                'message' => 'Error occurred while updating product.'
            ], 201);
        }
        return response()->json([
            'message' => 'Product updated successfully'
        ], 201);

    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['status' => 'Success']);
    }

}
