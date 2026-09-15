<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\IQVResultStoreRequest;
use App\Http\Requests\Survey\IQVResultUpdateRequest;
use App\Models\Survey\IQVResult;
use Illuminate\Http\Request;

class IQVResultController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iQVResults = IQVResult::all();

        return view('iQVResult.index', compact('iQVResults'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('iQVResult.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\IQVResult $iQVResult
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, IQVResult $iQVResult)
    {
        return view('iQVResult.show', compact('iQVResult'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\IQVResult $iQVResult
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, IQVResult $iQVResult)
    {
        return view('iQVResult.edit', compact('iQVResult'));
    }

    /**
     * @param \App\Http\Requests\Survey\IQVResultUpdateRequest $request
     * @param \App\Models\Survey\IQVResult $iQVResult
     * @return \Illuminate\Http\Response
     */
    public function update(IQVResultUpdateRequest $request, IQVResult $iQVResult)
    {
        $iQVResult->update($request->validated());

        $request->session()->flash('iQVResult.id', $iQVResult->id);

        return redirect()->route('iQVResult.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\IQVResult $iQVResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IQVResult $iQVResult)
    {
        $iQVResult->delete();

        return redirect()->route('iQVResult.index');
    }

    /**
     * @param \App\Http\Requests\Survey\IQVResultStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IQVResultStoreRequest $request)
    {
        $iqvResult = IqvResult::create($request->validated());

        $request->session()->flash('IqvResult.created-successfully', $IqvResult->created-successfully);

        return redirect()->route('Survey\IQVResult.index');
    }
}
