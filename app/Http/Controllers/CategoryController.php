<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\CategoryProduct;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::with('products')->get();
    
        if(!$category->count() > 0){
            return response()->json([
                'status' => "failed",
                'data' =>'no categories availabe',
                ],
                400
            );
        }

        return response()->json([
            'status' => "success",
            'data' =>$category,
            ],
            200
        );
    }

    public function create(Request $request)
    {
        $name = $request->get('name');
        if(empty($name)) return response()->json(['status'=>'failed','error' => 'name field is mandatory'],400);

        $category =  Category::create($request->all());
 
        return response()->json([
            'status' => "success",
            'data' =>$category,
            ],
            200
        );
    }

    public function edit(Request $request,$id)
    {
        $category = Category::find($id);
        if(!$category) return response()->json(['status'=>'failed','error' => 'there is no category with this id'],400);

        $name = $request->get('name');

        if(empty($name)) return response()->json(['status'=>'failed','error' => 'name field is mandatory'],400);
    
        $category->update($request->all());

        return response()->json([
            'status' => "success",
            'data' =>$category,
            ],
            200
        );
    }
    
    public function destroy($id)
    {
        $category = new  Category();
        $category =  $category->find($id);
        if(!$category) return response()->json(['status'=>'failed','error' => 'there is no category to delete'],400);

        $categoryProduct=  CategoryProduct::where('category_id', $id)->count();
        if($categoryProduct > 0) return response()->json(['status'=>'failed','error' => 'You cant remove category that have products'],400);

        $category->delete();

        return response()->json([
            'status' => "success",
            'data' =>$category,
            ],
            200
        );
    }
}
