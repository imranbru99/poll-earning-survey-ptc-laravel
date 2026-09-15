<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ptc;
use App\PublisherUser;
use Session;
class PtcController extends Controller
{

    public function index()
    {
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $page_title = 'PTC Ads';
        $empty_message = 'No Ads Created Yet.';

        $ptcs = Ptc::where('publisher_user_id',$user->id)->latest()->paginate(getPaginate());
        return view('publisher.ptc.index', compact('page_title', 'empty_message', 'ptcs'));
    }

    public function create()
    {
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        if($user->balance >= 1000){
            $page_title = 'Create New PTC Ad';
            return view('publisher.ptc.create', compact('page_title'));    
        }else{
            $notify[] = ['success', 'To Create New PTC Ads, Your Minimum balance Need 1500 Taka'];
            return redirect('publisher_user/deposit')->withNotify($notify);   
        }
        
    }


    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'ads_type' => 'required|numeric',
            'amount' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            'max_show' => 'required|numeric|min:1',
            'website_link' => 'nullable|url|required_without_all:banner_image,script',
            'banner_image' => 'nullable|mimes:jpeg,jpg,png,gif|required_without_all:website_link,script',
            'script' => 'nullable|required_without_all:website_link,banner_image',
        ]);

        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        
        $ptc = new Ptc();
        $ptc->publisher_user_id = $user->id;
        $ptc->title = $request->title;
        $ptc->amount = $request->amount;
        $ptc->duration = $request->duration;
        $ptc->max_show = $request->max_show;
        $ptc->remain = $request->max_show;
        $ptc->ads_type = $request->ads_type;
        $ptc->status = isset($request->status) ? 1:0;

            if($request->ads_type == 1){
                $ptc->ads_body = $request->website_link;
            }elseif($request->ads_type == 2){

                if ($request->hasFile('banner_image')) {
                    try {
                        $directory = date("Y")."/".date("m")."/".date("d");
                        $path = 'assets/images/ptcimages/'.$directory;
                        $filename = $directory.'/'.uploadImage($request->banner_image,$path);
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Image Could not be uploaded.'];
                        return back()->withNotify($notify);
                    }
                $ptc->ads_body = $filename;
                }
            }else{
                $ptc->ads_body = $request->script;
            }

        $ptc->save();

        $notify[] = ['success', 'PTC has been Created Successfully.'];
        return redirect('publisher_user/ptc')->withNotify($notify);
    }

    public function edit($id)
    {
        $page_title = 'Edit PTC Ad';
        $ptc = Ptc::findOrFail($id);
        return view('publisher.ptc.edit', compact('page_title','ptc','id'));
    }


    public function update(Request $request, $id) {

        
        $request->validate([
            'title' => 'required',
            'ads_type' => 'required|numeric',
            'amount' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            'max_show' => 'required|numeric|min:1',
        ]);

        $ptc = Ptc::findOrFail($id);
        $ptc->title = $request->title;
        $ptc->amount = $request->amount;
        $ptc->duration = $request->duration;
        $ptc->max_show = $request->max_show;
        $ptc->remain = $request->max_show - $ptc->showed;
        $ptc->ads_type = $request->ads_type;
        $ptc->status = isset($request->status) ? 1:0;

            if($request->ads_type == 1){
                $ptc->ads_body = $request->website_link;
            }elseif($request->ads_type == 2){
                $filename = $ptc->ads_body;
                if ($request->hasFile('banner_image')) {
                    try {
                        $old = $ptc->ads_body;
                        $directory = date("Y")."/".date("m")."/".date("d");
                        $path = 'assets/images/ptcimages/'.$directory;
                        removeFile('assets/images/ptcimages/'.$old);
                        $filename = $directory.'/'.uploadImage($request->banner_image,$path);
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Image Could not be uploaded.'];
                        return back()->withNotify($notify);
                    }
                }
                $ptc->ads_body = $filename;
            }else{
                $ptc->ads_body = $request->script;
            }



        $ptc->save();

        $notify[] = ['success', 'PTC has been Updated Successfully.'];
        return redirect('publisher_user/ptc')->withNotify($notify);
    }


}
