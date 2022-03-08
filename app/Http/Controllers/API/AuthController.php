<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use Cookie;
use CountryState;

class AuthController extends Controller
{
    //

     //Register

     public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => '|required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'affiliate_id' => Str::random(10),
            'password' => Hash::make($request->password)
        ]);
        $user->save();
        return response()->json(['message' => 'user has been registered', 'data'=>$user], 200);       
}

//login function

    public function login(Request $request)
    {
        $request-> validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean'
            
        ]);

        $login = request(['email', 'password']);

        if(!Auth::attempt($login))
        {
            return response(['message'=> 'Invalid login credentials'], 401);
        }

        $user = $request->user();
        $accessToken = $user->createToken('Personal Access Token');
        $token = $accessToken->token;
        $token ->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json(['data'=>[
            'user' => Auth::user(),
            'access_token' => $accessToken->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($accessToken->token->expires_at)->toDateTimeString()
        ]]);
    }
    //logout function

    public function logout() {

        if(Auth::check()) {
        Auth::user()->token()->revoke();
        return response()->json(["status" => "success", "error" => false, "message" => "Success! You are logged out."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! You are already logged out."], 403);
    }

    public function updateProfile(Request $request){
        try {
                $validator = Validator::make($request->all(),[
                'first_name' => 'string|min:2|max:45',
                'last_name' => 'string|min:2|max:45',
                'phone' => 'string',
                'country' => 'string',
                'city' => 'string',
                'state' => 'string',
                'usertype' => 'string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
                if($validator->fails()){
                    $error = $validator->errors()->all()[0];
                    return response()->json(['status'=>'false', 'message'=>$error, 'data'=>[]],422);
                }else{
                    $user = user::find($request->user()->id);
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->state = $request->state;
                    $user->usertype = $request->usertype;
                    $user->city = $request->city;
                    $user->country = $request->country;
                    $user->phone = preg_replace('/^0/','+234',$request->phone);
                    if($request->image && $request->image->isValid())
                    {
                        $file_name = time().'.'.$request->image->extension();
                        $request->image->move(public_path('images'),$file_name);
                        $path = "images/$file_name";
                        $user->image = $path;
                    }
                            $user->update();
                            return response()->json(['status'=>'true', 'message'=>"profile updated suuccessfully", 'data'=>$user]);
                }
    
        }catch (\Exception $e){
                    return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function getProfile(){
        $id = Auth::user();
        $getProfileFirst = user::where('id', $id->id)->get();
        return response()->json($getProfileFirst);

    }

    public function updateUsertype(Request $request)
    {
    $id = Auth::user();
    $user = User::where('id', $id->id)->firstOrFail(); 
    $user->usertype = $request->usertype;
    $user->saveOrFail();
    return response()->json(['success' => true]);
    }


    public function getCountry(){
        $countries = CountryState::getCountries();
        return response()->json($countries);
    }


    public function getState($state){
        $states = CountryState::getStates($state);
        return response()->json($states);
    }
   
   

}
