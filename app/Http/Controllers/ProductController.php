<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('stock.index');
    }

    public function getProducts(){
        $products = Product::with('product_category')->orderBy('product_name','asc')->get();
        return Datatables::of($products)->addColumn('action', function ($product) {
            $re = '/product-edit/' . $product->id;
            $sh = '/product/show/' . $product->id;
            $del = '/product/delete/' . $product->id;
            return '<a href=' . $re . ' title="Edit Product" style="color:green"><i class="material-icons">create</i></a><a href=' . $del . ' title="Delete Product" style="color:red"><i class="material-icons">delete_forever</i></a>';
        })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = ProductCategory::orderBy('category_name','asc')->get();
        return view('stock.product-create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        //
        $input = $request->validated();
        DB::beginTransaction();
        try{
            $path = $request->file('product_image_url')->store('products');
            $product = Product::create(['quantity'=>$input['quantity'],'product_image_url'=>$path,'product_name'=>$input['product_name'],'description'=>$input['description'],'price'=>$input['price'],'barcode'=>$input['barcode'],'category_id'=>$input['category_id']]);

            DB::commit();
            return response()->json(['message'=>'Product saved successfully','product'=>$product],200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occured while saving product, please contact IT admin'.$e->getMessage()],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories = ProductCategory::orderBy('category_name','asc')->get();
        return view('stock.product-edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        //
        $input = $request->validated();
        DB::beginTransaction();

        try{
            if($request->has('product_image_url')){
                $path = $request->file('product_image_url')->store('products');
                $product->update(['product_image_url'=>$path,'quantity'=>$input['quantity'],'category_id'=>$input['category_id'],'product_name'=>$input['product_name'],'description'=>$input['description'],'price'=>$input['price'],'barcode'=>$input['barcode']]);

            }else{
                $product->update(['category_id'=>$input['category_id'],'quantity'=>$input['quantity'],'product_name'=>$input['product_name'],'description'=>$input['description'],'price'=>$input['price'],'barcode'=>$input['barcode']]);

            }
             DB::commit();
            return response()->json(['message'=>'Product updated successfully','product'=>$product],200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occurred while updating product, please contact IT admin'.$e->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        DB::beginTransaction();
        try{
            $product->delete();
            DB::commit();
            return redirect('products');
        }catch(\Exception $e){
            return redirect('products');
//            return response()->json(['message'=>'An error occured while deleting the product '.$e->getMessage()],500);
        }

    }
}
