<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     * @return Product[]
     */
    public function index()
    {
//        $this->authorize('see-products');

        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $products = Product::create($request->all());

        return [
            'message' => 'Great success! New product created',
            'task' => $products
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return Product
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return array
     */
    public function update(Request $request, Product $product)
    {
        return ['message' => 'not now'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return array
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return ['message' => 'Successfully deleted product!'];
    }
}
