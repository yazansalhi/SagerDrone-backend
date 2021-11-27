<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {
        $errors = $this->validateLogin($request);

        if (count($errors)) {

            $errorResponse = $this->validationErrorsToString($errors);

            return response()->json([
                    'status' => 'failed',
                    'data' => [
                        'errors' => $errorResponse
                    ]
                ],
                400
            );
        }

        if (!auth()->attempt($request->only(['email', 'password']))) {
         
            return response()->json([
                'status' => 'failed',
                'data' => [
                    'errors' => 'The email address or password is incorrect'
                ]
            ],
            400
        );
        }

        $token = Str::random(60);
        auth()->user()->api_token = hash('sha256', $token);
        auth()->user()->save();


        return response()->json([
            'status' => "success",
            'data' => auth()->user(),
        ],
        200
    );
    }

    public function validateLogin($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|min:8|string',
        ]);

        return $validator->errors();
    }

    private function validationErrorsToString($errorsArray)
    {
        $validationArr = array();
        foreach ($errorsArray->toArray() as $key => $value) {
            $validationArr[$key] = $value[0];
        }
        return $validationArr;
    }
}