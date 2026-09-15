<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\AttemptSurveyStoreRequest;
use App\Http\Requests\Survey\AttemptSurveyUpdateRequest;
use App\Models\Survey\AttemptSurvey;
use Illuminate\Http\Request;

class AttemptSurveyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attemptSurveys = AttemptSurvey::all();

        return view('attemptSurvey.index', compact('attemptSurveys'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('attemptSurvey.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\AttemptSurvey $attemptSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AttemptSurvey $attemptSurvey)
    {
        return view('attemptSurvey.show', compact('attemptSurvey'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\AttemptSurvey $attemptSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AttemptSurvey $attemptSurvey)
    {
        return view('attemptSurvey.edit', compact('attemptSurvey'));
    }

    /**
     * @param \App\Http\Requests\Survey\AttemptSurveyUpdateRequest $request
     * @param \App\Models\Survey\AttemptSurvey $attemptSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(AttemptSurveyUpdateRequest $request, AttemptSurvey $attemptSurvey)
    {
        $attemptSurvey->update($request->validated());

        $request->session()->flash('attemptSurvey.id', $attemptSurvey->id);

        return redirect()->route('attemptSurvey.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\AttemptSurvey $attemptSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AttemptSurvey $attemptSurvey)
    {
        $attemptSurvey->delete();

        return redirect()->route('attemptSurvey.index');
    }

    /**
     * @param \App\Http\Requests\Survey\AttemptSurveyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttemptSurveyStoreRequest $request)
    {
        $attemptingSurvey = AttemptingSurvey::create($request->validated());

        $request->session()->flash('attemptingSurvey.stored-successfully', $attemptingSurvey->stored-successfully);

        return redirect()->route('AttemptSurvey.index');
    }
}
