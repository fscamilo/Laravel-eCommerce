<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\ProductsStock;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateProduct;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.pages.products.index', ['products' => $products]);
    }


    public function create()
    {
        return view('admin.pages.products.create');
    }


    public function store(CreateProduct $request)
    {
        $productVals = $request->except(['_token', 'stock']);
        $productVals['image'] = Helpers::handle_upload_request_image($request->image);
        $product = Product::create($productVals);
        $stockVals = [
            'base_stock' => $request->stock,
            'product_id' => $product->id
        ];
        ProductsStock::create($stockVals);
        return(redirect('/admin/products/'.$product->id));
    }


    public function show($id)
    {
        
    }


    public function edit($id)
    {
		$product = Product::find($id);
		$categories = Category::all();
        return view('admin.pages.products.edit', [
			'product' => $product,
			'categories' => $categories,
		]);
    }


    public function update(UpdateProduct $request, $id)
    {
		$productVals = $request->except('sku');
		$productVals['force_popular'] = ($request->has('force_popular') ? 1 : 0);
		$productVals['force_new'] = ($request->has('force_new') ? 1 : 0);
		$productVals['force_sale'] = ($request->has('force_sale') ? 1 : 0);
        if($request->image):
            $productVals['image'] = Helpers::handle_upload_request_image($request->image);
        endif;
        Product::find($id)->update($productVals);
        return redirect()->back()->with(['response' => ['success', 'Profile updated succesfully']]);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $returnData = [
            'message' => 'The following product was successfully removed',
            'data' => [$product->sku, $product->name, $product->description, $product->stock, $product->price],
            'headings' => ['SKU', 'Name', 'Description', 'Stock', 'Price'],
        ];
        $product->delete();
        return redirect('/admin/products')->with(['delete_response' => $returnData]);
	}
	
	public function statistics()
    {
		$products = Product::all();
        return view('admin.pages.products.statistics', ['products' => $products]);
    }

}
