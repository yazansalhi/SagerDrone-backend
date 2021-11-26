<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
      
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|string|email']);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );
        $response == Password::RESET_LINK_SENT;
        return $response == Password::RESET_LINK_SENT
            ? response()->json([
                'status' => 'success',
                    'data' => [
                        'message' =>'now we sent reset link to your email',
                    ]
                ], 200)
            : response()->json([
                'status' => 'failed',
                    'data' => [
                        'message' => 'email not found',
                    ]
                ], 400);
                
    }
}
