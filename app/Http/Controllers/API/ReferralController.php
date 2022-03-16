<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class ReferralController extends Controller
{
    //
// public function getReferred(){

//     $aff = User::where(['usertype' => 'developer'])
//     ->select('name', 'email', 'phone', 'created_at')->get();
//     return response()->json(['message' => 'success', 'data'=>$aff], 200);   

//     }


    public function getAffiliateId(){
        $id = Auth::user();
        $getAffiliate = user::where('id', $id->id)->where('usertype', 'developer')->select('affiliate_id')->get();
        return response()->json($getAffiliate);

    }

    public function getReferred(){
        $id = Auth::user();
        $getAffiliate = user::where('id', $id->id)->where('usertype', 'developer')->where('referred_by', $id->affiliate_id)->select('name', 'email', 'phone', 'created_at')->get();
        return response()->json($getAffiliate);

    }
   

}
