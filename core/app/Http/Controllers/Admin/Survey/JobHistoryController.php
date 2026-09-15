<?php

namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\MicrojobsRequest;
use App\Models\Survey\Category;
use App\Models\Survey\MicroJob;
use App\Models\Survey\UserMicroJob;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class JobHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function index()
    {

        $resultShow = DB::table('user_microjobs')
            ->where('user_microjobs.user_id',auth()->id())
            ->join('microjobs','microjobs.id','=','user_microjobs.microjob_id')
            ->join('users','users.id','=','user_microjobs.user_id')
            ->select('users.username','user_microjobs.id','user_microjobs.deleted_at','user_microjobs.created_at','user_microjobs.is_pending','user_microjobs.admin_feedback','microjobs.title','microjobs.amount','microjobs.time')
            ->orderBy("created_at", "DESC")
            ->get();
        $date = date('Y-m-d');
//        dd($resultShow);
        return view('templates.basic.user.microjobs.ShowHistory', [
            'result' => $resultShow,
            'page_title' => 'MicroJob History',
            'date' => $date,
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
    public function store()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update()
    {
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
