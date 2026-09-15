<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ptc;

class ClearShowedConroller extends Controller
{
    public function clearShowads(Request $request)
    {
        if($request->ajax()){
            if($request->has('Okay_Clear')){
                $adsrecords=Ptc::latest()->select('id', 'showed')->get();
                if($adsrecords !=null){
                    foreach ($adsrecords as $key => $record) {
                        // if ($key <=15) {
                            $record->update(['showed'=>0]);
                        // }
                    }
                    return response()->json(['adsCleared'=>'successfull'], 200);

                }else{
                    return response()->json(['failed'=>'Unable to Perform your request'], 201);
                }
            }else{
                return response()->json(['failed'=>'Unable to Perform your request'], 201);
            }
        }else{
            abort(404);
        }
    }
}
