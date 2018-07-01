<?php
namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Namshi\JOSE\JWT;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use \Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{


    /**
     *  @SWG\Post(
     *   path="/register",
     *   summary="Register user",
     *   operationId="register",
     *   tags={"auth"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="User that should be stored",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
    *          property="email",
    *          type="string"
    *      ),
     *     @SWG\Property(
     *          property="password",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="password_confirmation",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $credentials = $request->only( 'email', 'password','password_confirmation');

        $rules = [
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required',
               'min:6',
               'confirmed']
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $email = $request->email;
        $password = $request->password;
        $name = 'Customer';

        $user = User::create(['name' => $name,'email' => $email, 'password' => \Hash::make($password),'default_currency_id'=>Currency::all()->first()->id]);
        $verification_code = str_random(30); //Generate verification code
        \DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);
        $subject = "Please verify your email address.";
        \Mail::send('emails.verify', ['email' => $email, 'verification_code' => $verification_code],
            function($mail) use ($email,  $subject){
                $mail->from(getenv('FROM_EMAIL_ADDRESS'), "From User/Company Name Goes Here");
                $mail->to($email, 'Customer');
                $mail->subject($subject);
            });
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
    }


    /** API Login, on success return JWT Auth token
    @SWG\Post(
     *   path="/login",
     *   summary="Login user",
     *   operationId="login",
     *   tags={"auth"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Login",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="email",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="password",
     *          type="string"
     *      ),
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $credentials['is_verified'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token , 'user'=>\auth()->user()]]);
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     * @SWG\Get(
     *   path="/logout",
     *   summary="Logout",
     *   operationId="logout",
     *   tags={"auth"},
     *   @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="token",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(Request $request)
    {
        $check = \DB::table('user_verifications')->where('token',$request->verification_code)->first();

        if(!is_null($check)){
            $user = User::find($check->user_id);

            if($user->is_verified == 1){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Account already verified..'
                ]);
            }

            $user->update(['is_verified' => 1]);
            \DB::table('user_verifications')->where('token',$request->verification_code)->delete();

            return response()->json([
                'success'=> true,
                'message'=> 'You have successfully verified your email address.'
            ]);
        }

        return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);
    }

    /**
     * API Recover Password
     *    @SWG\Post(
     *   path="/recover",
     *   summary="Recover user",
     *   operationId="recover",
     *   tags={"auth"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Login",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="email",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try {
            $verification_code = str_random(60); //Generate verification code
            \DB::table('password_resets')->insert(['email'=>$request->email,'token'=>$verification_code]);
            $subject = "Reset your password.";
            $email = $request->email;
            \Mail::send('emails.reset', ['email' => $email, 'verification_code' => $verification_code],
                function($mail) use ($email,  $subject){
                    $mail->from(getenv('FROM_EMAIL_ADDRESS'), "From User/Company Name Goes Here");
                    $mail->to($email, 'Customer');
                    $mail->subject($subject);
                });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function showResetForm(Request $request){
        $email = \DB::table('password_resets')->where('token', $request->token)->get()->last();
        if (!$email){
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        return 'resetform';
    }

    /**
     * @param Request $request
     */
    public function resetPassword(Request $request){
        $email = \DB::table('password_resets')->where('token', $request->token)->get()->last();
        if (!$email){
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        $user = User::where('email', $email->email)->first();
        $rules = [
            'password' =>
                [
                    'required',
                    'min:6',
                    'confirmed'
                ]
        ];
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $user->password = \Hash::make($request->password);
        $user->save();
        \DB::table('password_resets')->where('email', $user->email)->delete();

        return response()->json([
            'success' => true, 'data'=> []
        ]);
    }
}