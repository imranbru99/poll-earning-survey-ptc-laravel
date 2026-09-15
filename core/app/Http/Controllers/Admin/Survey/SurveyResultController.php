<?php

namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\SurveyResultStoreRequest;
use App\Http\Requests\Survey\SurveyResultUpdateRequest;
use App\Models\Survey\SurveyResult;
use Illuminate\Http\Request;

class SurveyResultController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $surveyResults = SurveyResult::all();
        return view('surveyResult.index', compact('surveyResults'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('surveyResult.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\SurveyResult $surveyResult
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SurveyResult $surveyResult)
    {
        return view('surveyResult.show', compact('surveyResult'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\SurveyResult $surveyResult
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SurveyResult $surveyResult)
    {
        return view('surveyResult.edit', compact('surveyResult'));
    }

    /**
     * @param \App\Http\Requests\Survey\SurveyResultUpdateRequest $request
     * @param \App\Models\Survey\SurveyResult $surveyResult
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyResultUpdateRequest $request, SurveyResult $surveyResult)
    {
        $surveyResult->update($request->validated());

        $request->session()->flash('surveyResult.id', $surveyResult->id);

        return redirect()->route('surveyResult.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\SurveyResult $surveyResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SurveyResult $surveyResult)
    {
        $surveyResult->delete();

        return redirect()->route('surveyResult.index');
    }

    /**
     * @param \App\Http\Requests\Survey\SurveyResultStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyResultStoreRequest $request)
    {
        $surveyResult = SurveyResult::create($request->validated());

        $request->session()->flash('surveyResult.generated-successfully', $surveyResult->generated-successfully);

        return redirect()->route('Survey\SurveyResult.index');
    }
}
