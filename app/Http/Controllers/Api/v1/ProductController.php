<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Api\BaseController;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for Managing Products"
 * )
 */
class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepositoryInterface;
    
    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }
     /**
     * @OA\Get(
     *     path="/v1/products",
     *     summary="Get list of products",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Products fetched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Products fetched successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProductResource"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = $this->productRepositoryInterface->index();
        
        $product = ProductResource::collection($data);
        return $this->sendResponse($product, 'Products fetched successfully');
    }
    /**
     * @OA\Post(
     *     path="/v1/products",
     *     summary="Create a new product",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "details"},
     *             @OA\Property(property="name", type="string", example="Product Name"),
     *             @OA\Property(property="details", type="string", example="Product Details")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProductResource")
     *         )
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $details =[
            'name' => $request->name,
            'details' => $request->details
        ];
        
        try{
             $product = $this->productRepositoryInterface->store($details);

             $product = new ProductResource($product);

             return $this->sendResponse($product, 'product created successfully');

        }catch(\Exception $ex){
            Log::error("message : ". $ex->getMessage(). " line : ". $ex->getLine());
            return $this->sendError($ex->getMessage());
        }
    }
    
    /**
     * @OA\Get(
     *     path="/v1/products/{id}",
     *     summary="Get product by ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product fetched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product fetched successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProductResource")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $product = $this->productRepositoryInterface->getById($id);
        $productResource = new ProductResource($product);

        return $this->sendResponse($productResource, 'product fetched successfully');
    }
    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update product by ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "details"},
     *             @OA\Property(property="name", type="string", example="Updated Product Name"),
     *             @OA\Property(property="details", type="string", example="Updated Product Details")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProductResource")
     *         )
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $updateDetails =[
            'name' => $request->name,
            'details' => $request->details
        ];
        
        try{
             $product = $this->productRepositoryInterface->update($updateDetails,$id);

             $productResource = new ProductResource($product);

             return $this->sendResponse($product, 'product updated successfully');

        }catch(\Exception $ex){
            return $this->sendError($ex);

        }
    }
/**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete product by ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product deleted successfully"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
         $this->productRepositoryInterface->delete($id);
        

         return $this->sendResponse(null, 'product deleted successfully');
    }
}
