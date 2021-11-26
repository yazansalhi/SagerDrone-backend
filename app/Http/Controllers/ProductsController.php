<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\ProductCategory;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('updated_at','desc')->get();
        
        if(!$products->count() > 0){
            return response()->json([
                'status' => "failed",
                'data' =>'no products availabe',
                ],
                400
            );
        }

        return response()->json([
            'status' => "success",
            'data' =>$products,
            ],
            200
        );
    }

    public function create(Request $request)
    {
        $categoryIds = $request->get('category_ids');
        $name = $request->get('name');

        $categories = Category::whereIn('id',$categoryIds)->get();

        if(empty($name)) return response()->json(['status'=>'failed','error' => 'name field is mandatory'],400);
        if(empty($categoryIds)) return response()->json(['status'=>'failed','error' => 'You should select at least one category'],400);
        if(!is_array($categoryIds)) return response()->json(['status'=>'failed','error' => ' category_ids should be an array'],400);
        if(!$categories->count() > 0) return response()->json(['status'=>'failed','error' => 'there is no categories'],400);
      
      
         $product =  Product::create($request->all());
         $product = Product::find($product->id);
         $product->category()->sync($categoryIds);
           
        return response()->json([
            'status' => "success",
            'data' =>$product,
            ],
            200
        );
    }

    public function edit(Request $request,$id)
    {
        $product = Product::find($id);
        if(!$product) return response()->json(['status'=>'failed','error' => 'there is no product with this id'],400);

        $categoryIds = $request->get('category_ids');
        $name = $request->get('name');

        $categories = Category::whereIn('id',$categoryIds)->get();

        if(empty($name)) return response()->json(['status'=>'failed','error' => 'name field is mandatory'],400);
        if(empty($categoryIds)) return response()->json(['status'=>'failed','error' => 'You should select at least one category'],400);
        if(!is_array($categoryIds)) return response()->json(['status'=>'failed','error' => ' category_ids should be an array'],400);
        if(!$categories->count() > 0) return response()->json(['status'=>'failed','error' => 'there is no categories'],400);

       

         $product->update($request->all());
         $product->category()->sync($categoryIds);

        return response()->json([
            'status' => "success",
            'data' =>$product,
            ],
            200
        );
    }
    
    public function destroy($id)
    {
        $product = new Product();
        $product =  $product->find($id);
   
        if(!$product) return response()->json(['status'=>'failed','error' => 'there is no product to delete'],400);

        $product->delete();

        return response()->json([
            'status' => "success",
            'data' =>$product,
            ],
            200
        );
    }
    public function removeQuantity(Request $request){

        $productId = $request->get('product_id');
        if(empty($productId)) return response()->json(['status'=>'failed','error' => 'product_id field is mandatory'],400);

        $products = new Product();
        $product = $products->find($productId);
        if($product->quantity <= 1) return response()->json(['status'=>'failed','error' => 'there is one quantity from this product'],400);
        $product->quantity = $product->quantity - 1;
        $product->save();

        return response()->json([
            'status' => "success",
            'data' =>$product,
            ],
            200
        );
    }
}