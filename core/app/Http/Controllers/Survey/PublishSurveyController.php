<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\PublishSurveyStoreRequest;
use App\Http\Requests\Survey\PublishSurveyUpdateRequest;
use App\Models\Survey\PublishSurvey;
use Illuminate\Http\Request;

class PublishSurveyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $publishSurveys = PublishSurvey::all();

        return view('publishSurvey.index', compact('publishSurveys'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('publishSurvey.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\PublishSurvey $publishSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PublishSurvey $publishSurvey)
    {
        return view('publishSurvey.show', compact('publishSurvey'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\PublishSurvey $publishSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PublishSurvey $publishSurvey)
    {
        return view('publishSurvey.edit', compact('publishSurvey'));
    }

    /**
     * @param \App\Http\Requests\Survey\PublishSurveyUpdateRequest $request
     * @param \App\Models\Survey\PublishSurvey $publishSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(PublishSurveyUpdateRequest $request, PublishSurvey $publishSurvey)
    {
        $publishSurvey->update($request->validated());

        $request->session()->flash('publishSurvey.id', $publishSurvey->id);

        return redirect()->route('publishSurvey.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\PublishSurvey $publishSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PublishSurvey $publishSurvey)
    {
        $publishSurvey->delete();

        return redirect()->route('publishSurvey.index');
    }

    /**
     * @param \App\Http\Requests\Survey\PublishSurveyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublishSurveyStoreRequest $request)
    {
        $publishSurvey = PublishSurvey::create($request->validated());

        $request->session()->flash('publishSurvey.created-successfully', $publishSurvey->created-successfully);

        return redirect()->route('PublishSurvey.index');
    }
}
