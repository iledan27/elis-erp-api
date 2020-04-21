<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="index",
     *      tags={"Products"},
     *      description="Returns list of products",
     *      security={{"authbearer": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Product"),
     *          ),
     *      )
     * )
     */
    public function index()
    {
//        $this->authorize('see-products');

        return Product::all();
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      operationId="store",
     *      tags={"Products"},
     *      description="Returns the new product",
     *      security={{"authbearer": {}}},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 example={"name": "test product"}
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successfully added a new product",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      )
     * )
     *
     * @param  Request  $request
     * @return Product
     */
    public function store(Request $request)
    {
        return Product::create($request->all());
    }

    /**
     * @OA\Get(
     *      path="/api/products/{id}",
     *      operationId="show",
     *      tags={"Products"},
     *      description="Returns a product",
     *      security={{"authbearer": {}}},
     *      @OA\Parameter(
     *         description="ID of a product",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      )
     * )
     *
     * @param  Product  $product
     * @return Product
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * @OA\Put(
     *      path="/api/products/{id}",
     *      operationId="update",
     *      tags={"Products"},
     *      description="Returns the updated product",
     *      security={{"authbearer": {}}},
     *      @OA\Parameter(
     *         description="ID of a product",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 example={"name": "test product"}
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      )
     * )
     *
     * @param Request $request
     * @param Product $product
     * @return Product
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return $product;
    }

    /**
     * @OA\Delete(
     *      path="/api/products/{id}",
     *      operationId="destroy",
     *      tags={"Products"},
     *      description="Delete a product",
     *      security={{"authbearer": {}}},
     *      @OA\Parameter(
     *         description="ID of a product",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              example={"message": "This is a success message"}
     *          )
     *      )
     * )
     *
     * @param Product $product
     * @return Product
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $deletedProduct = $product;

        $product->delete();

        return $deletedProduct;
    }
}
