<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Support\Facades\Password;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    public function reset(Request $request)
    {
       
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        $response = $this->broker()->reset(
            $this->credentials($request),function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'message' => trans('passwords.reset'),
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'data' => [
                    'message' => trans($response),
                ]
            ], 400);
        }

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::RESET_LINK_SENT
            ? response()->json([
                'status' => 'success',
                    'data' => [
                        'message' => $response,
                    ]
                ], 200)
            : response()->json([
                'status' => 'failed',
                    'data' => [
                        'message' => $response,
                    ]
                ], 400);
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|string']);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ];
    }

      /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
