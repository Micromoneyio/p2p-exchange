<?php
namespace App\Http\Controllers;

use App\Currency;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Namshi\JOSE\JWT;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use \Tymon\JWTAuth\Facades\JWTAuth;
//use Illuminate\Support\Facades\Auth;

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
     *         property="email",
     *         type="string"
     *     ),
     *     @SWG\Property(
     *         property="name",
     *         type="string"
     *     ),
     *     @SWG\Property(
     *          property="password",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="password_confirmation",
     *          type="string"
     *      ),
     *   @SWG\Property(
     *          property="recaptcha",
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
        $credentials = $request->only( 'email', 'password','password_confirmation','recaptcha', 'name');

        $rules = [
            'email' => 'required|email|max:255|unique:users',
            'password' => [
                'required',
               'min:6',
               'confirmed'],
            'recaptcha'=>'required',
            'name' =>'required|string|max:255'
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }elseif (!$this->validateRecaptcha($request->{'recaptcha'})){
            return response()->json(['success'=> false, 'error'=> ['recaptcha'=>['Recaptcha Failed']]]);
        }

        $email = $request->email;
        $password = $request->password;
        $name = $request->name;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => \Hash::make($password),
            'default_currency_id'=>Currency::all()->first()->id,
            'facebook_id'=>$request->facebook_id
        ]);
        $verification_code = str_random(30); //Generate verification code
        \DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);
        $subject = "Please verify your email address.";
        \Mail::send('emails.verify', ['email' => $email, 'verification_code' => $verification_code],
            function($mail) use ($email,  $subject){
                $mail->from(getenv('FROM_EMAIL_ADDRESS'), getenv('APP_NAME'));
                $mail->to($email, 'Customer');
                $mail->subject($subject);
            });
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
    }

    private function validateRecaptcha($value){
        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'=>env('GOOGLE_RECAPTCHA_SECRET'),
                    'response'=>$value
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        return $body->success;
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
     *   @SWG\Property(
     *          property="recaptcha",
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
        $credentials = $request->only('email', 'password', 'recaptcha');
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'recaptcha'=>'required'
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }elseif (!$this->validateRecaptcha($request->{'recaptcha'})){
            return response()->json(['success'=> false, 'error'=> ['recaptcha'=>['Recaptcha failed']]]);
        }

        $credentials['is_verified'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            unset($credentials['recaptcha']);
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => ['email'=>['We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.']]]);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => ['email'=>['Failed to login, please try again.']]]);
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
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.']);
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
                return redirect()->away(getenv('APP_URL'). 'login?action_type=EMAIL_CONFIRMED');
            }

            $user->update(['is_verified' => 1]);
            \DB::table('user_verifications')->where('token',$request->verification_code)->delete();

            return redirect()->away(getenv('APP_URL'). 'login?action_type=EMAIL_CONFIRMED');
        }
        return redirect()->away(getenv('APP_URL'));
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
            return response()->json(['success' => false, 'error' => ['email'=> [$error_message]]]);
        }
        try {
            $verification_code = str_random(60); //Generate verification code
            \DB::table('password_resets')->insert(['email'=>$request->email,'token'=>$verification_code]);
            $subject = "Reset your password.";
            $email = $request->email;
            \Mail::send('emails.reset', ['email' => $email, 'verification_code' => $verification_code],
                function($mail) use ($email,  $subject){
                    $mail->from(getenv('FROM_EMAIL_ADDRESS'), getenv('APP_NAME'));
                    $mail->to($email, 'Customer');
                    $mail->subject($subject);
                });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message]);
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
            return response()->json(['success' => false, 'error' => ['email'=> [$error_message]]]);
        }
        return redirect()->away(getenv('APP_URL'). 'password-new?token='. $request->token);

    }

    /**
     * @param Request $request
     */
    public function resetPassword(Request $request){
        $email = \DB::table('password_resets')->where('token', $request->token)->get()->last();
        if (!$email){
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> [$error_message]]]);
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

    /**
     * Google
     * @SWG\Post(
     *   path="/login/google",
     *   summary="Google login",
     *   operationId="googleLogin",
     *   tags={"auth"},
     *     @SWG\Parameter(
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
     *          property="name",
     *          type="string"
     *      ),
     *   @SWG\Property(
     *          property="google_id",
     *          type="string"
     *      ),
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function googleLogin(Request $request)  {
        $credentials = $request->only('name', 'email', 'google_id');
        $rules = [
            'email' => 'required|email',
            'google_id'=>'required',
            'name' =>'required|string|max:255'
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $credentials['is_verified'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            $user = User::where([
                ['google_id','=',$request->google_id]
            ])->get()->first();
            if ($user){
                $token = JWTAuth::fromUser($user);
            }else{
                $user = User::create([
                    'name' => $credentials['name'],
                    'email' => $credentials['email'],
                    'password' => \Hash::make(str_random()),
                    'default_currency_id'=>Currency::all()->first()->id,
                    'is_verified'=>1,
                    'google_id' => $request->google_id
                ]);

                  $token = JWTAuth::fromUser($user);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => ['email'=>['Failed to login, please try again.']]]);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token , 'user'=>$user]]);
    }
    /**
     * Facebook
     * @SWG\Post(
     *   path="/login/facebook",
     *   summary="facebook login",
     *   operationId="facebook Login",
     *   tags={"auth"},
     *     @SWG\Parameter(
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
     *          property="name",
     *          type="string"
     *      ),
     *   @SWG\Property(
     *          property="facebook_id",
     *          type="string"
     *      ),
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function facebookLogin(Request $request)  {
        $credentials = $request->only('name', 'email', 'id');
        $rules = [
            'id'=>'required'
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $credentials['is_verified'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user

            $user = User::where([
                ['facebook_id','=',$request->id]
            ])->get()->first();
            if ($user){
                $token = JWTAuth::fromUser($user);
            }else{
                $user = User::create([
                    'name' => $credentials['name'],
                    'email' => $credentials['email'],
                    'password' => \Hash::make(str_random()),
                    'default_currency_id'=>Currency::all()->first()->id,
                    'is_verified'=>1,
                    'facebook_id' => $request->id
                ]);
                $token = JWTAuth::fromUser($user);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => ['email'=>['Failed to login, please try again.']]]);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token , 'user'=>$user]]);
    }

    public function listGoogleUser(Request $request){
        $users = User::orderBy('id','DESC')->paginate(5);
        return view('users.list',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);;
    }

    /**
     * Facebook
     * @SWG\Get(
     *   path="/login/facebook",
     *   summary="Facebook login",
     *   operationId="redirectToFacebook",
     *   tags={"auth"},
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToFacebook()
    {
        return response()->json(['success'=>true, 'data'=>['redirect'=>Socialite::driver('facebook')->redirect()->getTargetUrl()]]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $create['name'] = $user->getName();
            $create['email'] = $user->getEmail();
            $create['facebook_id'] = $user->getId();

            $userModel = new User;
            $createdUser = $userModel->addNew($create);
            Auth::loginUsingId($createdUser->id);

            return redirect()->route('home');
        }
        catch (\Exception $e) {
            return redirect('auth/facebook');
        }
    }

    public function connectFacebook(Request $request){
        $credentials = $request->only('facebook_id');
        $rules = [
            'facebook_id'=>'required',
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $user = $request->user();
        $user->facebook_id = $credentials['facebook_id'];
        $user->save();
        return response()->json(['success' => true, 'data'=> ['user'=>$user]]);
    }

    public function connectGoogle(Request $request){
        $credentials = $request->only('google_id');
        $rules = [
            'google'=>'required',
        ];
        $validator = \Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $user = $request->user();
        $user->google_id = $credentials['google_id'];
        $user->save();
        return response()->json(['success' => true, 'data'=> ['user'=>$user]]);
    }
}
