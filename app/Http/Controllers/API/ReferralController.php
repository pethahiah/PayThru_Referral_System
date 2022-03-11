<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class ReferralController extends Controller
{
    //
public function getReferred(){

    $gett = User::where(['referred_by' => Auth::user()->affiliate_id]) ->select('name', 'email', 'phone')->get();
    // $aff = User::where(['usertype' => 'developer'])
//    ->get();
    return response()->json(['message' => 'success', 'data'=>$gett], 200);   

    }

}
