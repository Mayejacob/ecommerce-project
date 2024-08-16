<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Api\BaseController;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends BaseController
{
    private ProductRepositoryInterface $productRepositoryInterface;
    
    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }
    public function index()
    {
        $data = $this->productRepositoryInterface->index();
        
        $product = ProductResource::collection($data);
        return $this->sendResponse($product, 'Products fetched successfully');
    }
    public function store(StoreProductRequest $request)
    {
        $details =[
            'name' => $request->name,
            'details' => $request->details
        ];
        
        try{
             $product = $this->productRepositoryInterface->store($details);

             $product = ProductResource::collection($product);

             return $this->sendResponse($product, 'product created successfully');

        }catch(\Exception $ex){
            return $this->sendError($ex);
        }
    }
    public function show($id)
    {
        $product = $this->productRepositoryInterface->getById($id);
        $product = ProductResource::collection($product);

        return $this->sendResponse($product, 'product fetched successfully');
    }
    public function update(UpdateProductRequest $request, $id)
    {
        $updateDetails =[
            'name' => $request->name,
            'details' => $request->details
        ];
        
        try{
             $product = $this->productRepositoryInterface->update($updateDetails,$id);

             $product = ProductResource::collection($product);

             return $this->sendResponse($product, 'product updated successfully');

        }catch(\Exception $ex){
            return $this->sendError($ex);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $this->productRepositoryInterface->delete($id);
        

         return $this->sendResponse(null, 'product deleted successfully');
    }
}
