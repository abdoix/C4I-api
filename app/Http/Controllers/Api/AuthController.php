<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use GeneralTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.guard:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $rules=[
                "email"=>"required",
                "password"=>"required"
            ];

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            //$mainProvider = $this->auth('provider-api');


            // Login
            $credentials = $request->only(['email','password']);

            if (! $token = auth()->attempt($credentials)) {
                return $this->returnError('E001','invalide inforamation!');
            }

            //return $this->respondWithToken($token);
            $user = auth()->user();
            $user->token = $token;
            return $this->returnData('user',$user);


        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }
    }


    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => '/assets/images/avatar.png',
            'phone'=>$request->phone,
        ]);

        //$this->login($request);
        // Login
        $credentials = $request->only(['email','password','phone']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->returnError('E001','invalide inforamation!');
        }

        //return $this->respondWithToken($token);
        $user = auth()->user();
        $user->token = $token;
        //return $this->returnData('user',$user);
        return $this->returnData("user",$user,'User successfully registered');
    }





    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        //$token = $request->header('auth-token');
        $user = auth()->user();
        if(!$user){
            return $this->returnError('','some thing went wrongs token not found');
        }
        return $this->returnData('user',$user);
    }


    public function logout(Request $request)
    {
            auth()->logout();// Logout
            return $this->returnSuccessMessage("Successfully logged out");

        //return $this->returnError('','some thing went wrongs');
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        //return $this->respondWithToken(auth()->refresh());
        return $this->returnData('token',auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }





    public function changeuser(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }*/
        //http://192.168.1.110/c4i/assets/images/1653426210.jpg
        $file_name = $this->saveimage($request->photo,'assets/images/');
        $mainuser = auth()->user();
        $mainuser->name = $request->name;
        $mainuser->email = $request->email;
        $mainuser->photo = "/assets/images/".$file_name;
        $mainuser->password = $request->password;
        $mainuser->save();


        if(!$mainuser->wasChanged()){
            return $this->returnError("",'User successfully chabged');
        }
        return $this->returnData("user",$mainuser,'User successfully chabged');
    }
}
