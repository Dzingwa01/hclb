<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryStoreRequest;
use App\ProductCategory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
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
        return view('stock.product-category-index');
    }

    public function getProductCategories(){
        $categories = ProductCategory::orderBy('category_name','asc')->get();

        return Datatables::of($categories)->addColumn('action', function ($category) {
            $re = '/product-category-edit/' . $category->id;
            $sh = '/product-category/show/' . $category->id;
            $del = '/product-category/delete/' . $category->id;
            return '<a href=' . $re . ' title="Edit Product Category" style="color:green"><i class="material-icons">create</i></a><a href=' . $del . ' title="Delete Product Category" style="color:red"><i class="material-icons">delete_forever</i></a>';
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryStoreRequest $request)
    {
        //
        $input = $request->validated();
        DB::beginTransaction();

        try{
            $category =ProductCategory::create($input);
            DB::commit();
            return response()->json(['message'=>'Product Category saved successfully','category'=>$category],200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occurred while saving the product Category '.$e->getMessage()],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        //
        return view('stock.product-category-edit',compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryStoreRequest $request, ProductCategory $productCategory)
    {
        //
        $input = $request->validated();
        DB::beginTransaction();

        try{
            $productCategory->update($input);
            DB::commit();
            return response()->json(['message'=>'Product Category updated successfully'],200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occurred while updating the product Category '.$e->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
        DB::beginTransaction();
        try{
            $productCategory->delete();
            DB::commit();
            return redirect('product-categories');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect('product-categories');
        }
    }
}
