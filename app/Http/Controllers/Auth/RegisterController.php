<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $token = Str::random(60);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => hash('sha256', $token),
        ]);
    }
    protected function register(Request $request)
    {
        $errors = $this->validator($request->all())->errors();
        if (count($errors)) {
            
            $errorResponse = $this->validationErrorsToString($errors);
           
            return response()->json([
                    'status' => "failed",
                    'data' => [
                        'errors' => $errorResponse
                    ]
                ],
                400
            );
        }
        $user = $this->create($request->all());
        
        return response()->json([
            'status' => "success",
            'data' => $user,
        ],
        200
    );
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
