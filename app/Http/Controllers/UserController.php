<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
    
        if(!$users->count() > 0){
            return response()->json([
                'status' => "failed",
                'data' =>'no users availabe',
                ],
                400
            );
        }

        return response()->json([
            'status' => "success",
            'data' =>$users,
            ],
            200
        );
    }

    public function create(Request $request)
    {

        $rules = [
            'email' => 'required|string|email|unique:user',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/'
        ];

        $messages = [
            'password.regex' => 'password should contain a number and an uppercase letter.'
        ];

        $validation = Validator::make($request->all(), $rules,$messages);

        if(count($validation->errors())) {
            return response()->json(
                [
                    'status' => "failed",
                    'data' => [
                        'errors' => $validation->errors()
                    ]
                ],
                400
            );
        }

        $user =  User::create([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
 
        return response()->json([
            'status' => "success",
            'data' =>$user,
            ],
            200
        );
    }

    public function edit(Request $request,$id)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'password' => 'sometimes|required|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/'
        ];

        $messages = [
            'password.regex' => 'password should contain a number and an uppercase letter.'
        ];

        $validation = Validator::make($request->all(), $rules,$messages);

        if(count($validation->errors())) {
            return response()->json(
                [
                    'status' => "failed",
                    'data' => [
                        'errors' => $validation->errors()
                    ]
                ],
                400
            );
        }

        $user = User::find($id);
        if(!$user) return response()->json(['status'=>'failed','error' => 'there is no user with this id'],400);

        $name = $request->get('name');
        $password = $request->get('password');

        if(!empty($password)){
            $user->update([
                'name'=>$name,
                'password' => Hash::make($password),
            ]);
        }else{
            $user->update($request->all());
        }
       

        return response()->json([
            'status' => "success",
            'data' =>$user,
            ],
            200
        );
    }
    
    public function destroy($id)
    {
        $user = new  User();
        $user =  $user->find($id);
        if(!$user) return response()->json(['status'=>'failed','error' => 'there is no user to delete'],400);

        $userHaveProduct =  Product::where('create_user_id', $user->id)->get();
       
        if($userHaveProduct->count() > 0) return response()->json(['status'=>'failed','error' => 'You cant remove user who have products'],400);

        $user->delete();

        return response()->json([
            'status' => "success",
            'data' =>$user,
            ],
            200
        );
    }
}
