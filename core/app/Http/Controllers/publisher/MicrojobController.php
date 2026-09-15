<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Survey\MicrojobsRequest;
use App\Models\Survey\Category;
use App\Models\Survey\MicroJob;
use App\Models\Survey\MicroJobAttachment;
use App\Models\Survey\UserMicroJob;
use App\User;
use App\PublisherUser;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\True_;
use Session;

class MicroJobController extends Controller
{
    public function index()
    {   
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $jobs = MicroJob::where('publisher_user_id',$user->id)->with('category')->get();
        return view('publisher.microjob.index', [
            'jobs' => $jobs,
            'page_title' => "View MicroJobs",
            'action' => route('microJobs.update' , 0)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id, Request $request)
    {
        // return $request;

        UserMicroJob::where('id',$id)->update(['admin_feedback'=>$request->details]);
        $user = UserMicroJob::findOrFail($id);
        if($user->is_submited == 0){
            $user['is_pending'] = 1;
            $user->save();
            $jobAmount = MicroJob::findOrFail($user->microjob_id);
            $jobAmount->remaining_limit = $jobAmount->remaining_limit - 1;
            $oldAmount = User::findOrFail($user->user_id);
            $oldAmount->balance = $oldAmount->balance + $jobAmount->amount;

            $oldAmount->save();
            $jobAmount->save();
            $notify[] = ['success', 'MicroJob Approved Successfully'];

            return redirect(route('microJobs.submitting'))->withNotify($notify);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $categories = Category::all();
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        // return $id;
        if($id != 0){
            return view('publisher.microjob.form', [
                'categories' => $categories,
                'jobs' => $this->getViewParams($id),
                'page_title' => 'Create New MicroJobs',
                'action' => route('publisher_user.microJobs.update' , $id)
            ]);
        }else{
            if($user->balance >= 1000){
                return view('publisher.microjob.form', [
                    'categories' => $categories,
                    'jobs' => $this->getViewParams($id),
                    'page_title' => 'Create New MicroJobs',
                    'action' => route('publisher_user.microJobs.update' , $id)
                ]);  
            }else{
                $notify[] = ['success', 'To Create New Microjob, Your Minimum balance Need 1500 Taka '];
                return redirect('publisher_user/deposit')->withNotify($notify);   
            }
        }

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(MicrojobsRequest $microjobsRequest, $id)
    {
        // return $microjobsRequest; 
        $data = $microjobsRequest->except('_token', '_method');
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $data['publisher_user_id'] = $user->id;
        $data['title'] = ucwords(strtolower($data['title']));
        $data['description'] = ucwords(strtolower($data['description']));
        $data['set_of_jobs'] = ucwords(strtolower($data['set_of_jobs']));
        $data['remaining_limit']  =$data['limit'] ;
        MicroJob::updateOrCreate(['id' => $id], $data);
        $notify[] = ['success', 'MicroJob Added Successfully'];
        return redirect('publisher_user/microJobs')->withNotify($notify);


        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

    }
    public function delete($id,Request $request){
        // return $id;
        UserMicroJob::where('id',$id)->update(['admin_feedback'=>$request->details]);
        try {
            $data = UserMicroJob::findOrFail($id);
            $data->delete();
            $notify[] = ['success', 'MicroJob deleted Successfully.'];

            return redirect(route('microJobs.submitting'))->withNotify($notify);
        }
        catch (\Exception $error) {
            return response(['error' => 'MicroJobs Not Deleted.'],400);
        }
    }
    public function submitting(){

        $result = DB::table('user_microjobs')->where('microjob_id','!=', 0)
            ->where('is_pending','=',0)
            ->join('microjobs','microjobs.id','=','user_microjobs.microjob_id')
            ->join('users','users.id','=','user_microjobs.user_id')
           ->select('user_microjobs.comment','user_microjobs.deleted_at','users.username','user_microjobs.id','user_microjobs.is_pending','microjobs.title','microjobs.amount','microjobs.time')
            ->get();
        return view('survey.microjob.submitting', [
            'result' => $result,
            'page_title' => 'Submitting MicroJobs',
        ]);

    }
    public function submitted(){
        $resultShow = DB::table('user_microjobs')
            ->where('microjob_id','!=', 0)
//            ->where('is_pending','=',0 )
            ->join('microjobs','microjobs.id','=','user_microjobs.microjob_id')
            ->join('users','users.id','=','user_microjobs.user_id')
            ->select('users.username','user_microjobs.deleted_at','user_microjobs.id','user_microjobs.is_pending','microjobs.title','microjobs.amount','microjobs.time')
            ->get();
//        dd($resultShow);
        return view('survey.microjob.submitted', [
            'result' => $resultShow,
            'page_title' => 'Submitted MicroJobs',
        ]);
    }
    private function getViewParams($id = 0)
    {
        $data = new MicroJob();
        if ($id > 0) {
            $data = MicroJob::findOrFail($id);
//            dd($data);
        }
        return $data;
    }
    public function showImage($id){
        $images = MicroJobAttachment::where('user_microjob_id',$id)->get('image');
        $output = '';
        if(count($images) > 0){
            foreach($images as $key => $img){
                $output .=   '<div class="col-12 col-md-6  col-sm-12 col-lg-4">
                                <div style="width:300px ; height: 300px; ">
                                    <div class="zoom">
                                        <img src="'.url("uploads/userjobs/".$img->image).'"  alt="Image here">
                                    </div>
                                </div>
                            </div>';
            }
        }else{
            $output = '<div class="col-4 col-md-4 col-lg-4 mt-4">
                            <div style="width:300px ; height: 50px; ">
                                No Image
                            </div>
                        </div>';
        }
        return response()->json([
            'output' => $output,
            'status' => true,
        ]);    
    }
    public function jobDelete($id){
        try {
            $data = MicroJob::findOrFail($id);
            $data->delete();
            $notify[] = ['success', 'MicroJob Deleted Successfully.'];

            return redirect('publisher_user/microJobs')->withNotify($notify);
        }
        catch (\Exception $error) {
            return response(['error' => 'MicroJobs Not Deleted.'],400);
        }
    }
    
   public function getInfoForModal($id)
    {
        // $myid= $id.'29493';   this is called application tolerance testing and security.
        $info=MicroJob::with('category')->where('id', $id)->first(['id',
            'title', 'description', 'set_of_jobs', 'category_id'
        ]);
        if($info !=null){
             return response()->json(['info'=>$info]);
        }else{
            return response()->json(['info'=>'No Record fund']);
        }
    }
}
