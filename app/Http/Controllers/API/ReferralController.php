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

    $aff = User::where(['usertype' => 'developer'])
    ->select('name', 'email', 'phone', 'created_at')->get();
    return response()->json(['message' => 'success', 'data'=>$aff], 200);   

    }

}
