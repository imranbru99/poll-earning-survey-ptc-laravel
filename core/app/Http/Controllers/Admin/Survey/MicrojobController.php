<?php

namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\MicrojobsRequest;
use App\Models\Survey\Category;
use App\Models\Survey\MicroJob;
use App\Models\Survey\MicroJobAttachment;
use App\Models\Survey\UserMicroJob;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class MicrojobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

        $jobs = DB::table('microjobs')
                    ->leftJoin('user_microjobs', function ($join){
                        $join->on('microjobs.id', '=', 'user_microjobs.microjob_id')->where('user_microjobs.user_id', '=', auth()->id() );})
                    ->select('microjobs.*', 'user_microjobs.microjob_id','user_microjobs.comment')
                    ->orderBy('id','DESC')->where('status',1)->latest()->get();

        $date = date('Y-m-d');
        return view('templates.basic.user.microjobs.index', [
            'jobs' => $jobs,
            'date' => $date,
            'page_title' => 'Micro Jobs'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('4');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {

          $id     = Crypt::decryptString($id);
          $jobs = MicroJob::findOrFail($id);
//          dd($jobs);
          return view('templates.basic.user.microjobs.form', [
            'page_title' => 'MicroJob Applying',
              'id' => $id,
              'job' =>$jobs,
              'action' => route('user.microJobs.update', $id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
          $userId = auth()->id();
          $checkjob = UserMicroJob::where('microjob_id',$id)
              ->where('user_id',$userId)
              ->get();
          $data['microjob_id'] = $id;
          $data['user_id'] = $userId;
          $date =date('Y-m-d');
          $data['date'] = $date;
          $limit = DB::table('user_microjobs')->where('user_id','=',$userId)
                        ->where('date','=',$date)->count();


          if($checkjob->isEmpty())
          {
              if ($limit < 5)
              {
//                  UserMicroJob::Create($data);

                  $notify[] = ['success', 'Please read attentively and Follow step what we wanted from You then Submit '];
                  return redirect( route('user.microJobs.show', $id))->withNotify($notify);


              }
              else{
                  $notify[] = ['error', 'Today Microjob Limit Full'];
              }
          }
          else
          {
              $notify[] = ['error', 'User MicroJob Already Exist'];
          }
        return redirect(route('user.microJobs.index'))->withNotify($notify);
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

        $product = $microjobsRequest->except('_token', '_method');
        $imgs = $microjobsRequest->file('attachments');
        $userId = Auth()->id();
        $date =date('Y-m-d');
        $product['date'] = $date;
        $product['user_id'] = $userId;
//        $finduser = UserMicroJob::where('microjob_id',$id)->get('id');
//        $finduser1 = UserMicroJob::where('user_id',$userId)->get('id');
//        $idss = $finduser1[0]->id;
//        $ids = $finduser[0]->id;
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');
        $this->validate($microjobsRequest, [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
        ]);
        $sub = UserMicroJob::Create($product);
        $destinationPath = 'uploads/userjobs/';
        if ($microjobsRequest->hasFile('attachments')) {
            foreach ($microjobsRequest->file('attachments') as  $image) {
                try {
                    MicroJobAttachment::create([
                        'user_microjob_id' => $sub->id,
                        'image' => uploadImage($image, $destinationPath),
                    ]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }
        $notify[] = ['success', 'MicroJob Added Successfully. '];

        $mes = 'MicroJob Added Successfully.';
        return redirect(route('user.microJobs.index'))->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
