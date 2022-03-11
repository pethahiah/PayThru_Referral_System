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

    $aff = User::where(['usertype' => 'developer', 'referred_by' => Auth::user()->affiliate_id])
    ->select('name', 'email')->get();
    return response()->json(['message' => 'success', 'data'=>$aff], 200);   

    }

}
