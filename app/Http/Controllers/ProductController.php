<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = DB::table('products')->where('status', 't');

        if ($request->get('cate_id') != '') {
            $products->where('cate_id', $request->get('cate_id'));
        }

        if ($request->get('product_name') != '') {
            $products->where('product_name', $request->get('product_name'));
        }

        return response()->json(['data' => $products->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = DB::table('categories')
            ->where('id', $request->get('cate_id'))->first();

        if (!isset($category)) {
            return response()->json(['warning' => 'category id not found.'], 404);
        }

        $product = Product::where('cate_id', $request->get('cate_id'))
            ->where('product_name', $request->get('product_name'))
            ->where('status', 't')->first();
        if (isset($product)) {
            return response()->json(['error' => 'product name is exist.'], 204);
        }

        Product::create($request->all());

        return response()->json(['message' => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->where('status', 't')->first();

        if ($product) {
            return response()->json(['data' => $product], 200);
        }

        return response()->json(['error' => 'product id found not.'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        if (!isset($product)) {
            return response()->json(['error' => 'product id not found.'], 404);
        }

        $check_product = Product::where('id', '!=', $id)
            ->where('product_name', $request->get('product_name'))
            ->where('cate_id', $request->get('cate_id'))
            ->where('status', 't')->first();

        if (isset($check_product)) {
            return response()->json(['error' => 'product name is exist.'], 203);
        }

        DB::table('products')
            ->where('id', $id)
            ->update($request->all());


        return response()->json(['data' => 'product update successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->where('status', 't')->first();

        if ($product) {

            $product->status = 'f';

            $product->save();

            return response()->json(
                ['data' => 'product id is delete.'],
                202
            );
        }
        return response()->json(['error' => 'product id not found.'], 404);
    }
}
