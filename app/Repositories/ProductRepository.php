<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function index(){
        return Product::all();
    }

    public function getById($id){
       return Product::findOrFail($id);
    }

    public function store(array $data){
       return Product::create($data);
    }

    public function update(array $data,$id){
      $product = Product::findOrFail($id);

      // Update the product with the new data
      $product->update($data);
  
      // Return the updated product instance
      return $product;
    }
    
    public function delete($id){
       Product::destroy($id);
    }
}
