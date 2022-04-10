<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class ReferralController extends Controller
{
    //

    public function getReferredCount(){
        $getAffiliateCount = user::where('referred_by', Auth::user()->affiliate_id)->count();
        return response()->json(['success' => true, 'Data' => $getAffiliateCount]);

    }


    public function getReferred(){
        $getAffiliate = user::where('referred_by', Auth::user()->affiliate_id)->select('name', 'email', 'phone', 'created_at', 'referred_by')->latest()->get();
        return response()->json($getAffiliate);

    }
   

}
