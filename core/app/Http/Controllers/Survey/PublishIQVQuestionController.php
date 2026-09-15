<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\PublishIQVQuestionStoreRequest;
use App\Http\Requests\Survey\PublishIQVQuestionUpdateRequest;
use App\Models\Survey\PublishIQVQuestion;
use Illuminate\Http\Request;

class PublishIQVQuestionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $publishIQVQuestions = PublishIQVQuestion::all();

        return view('publishIQVQuestion.index', compact('publishIQVQuestions'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('publishIQVQuestion.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\PublishIQVQuestion $publishIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PublishIQVQuestion $publishIQVQuestion)
    {
        return view('publishIQVQuestion.show', compact('publishIQVQuestion'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\PublishIQVQuestion $publishIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PublishIQVQuestion $publishIQVQuestion)
    {
        return view('publishIQVQuestion.edit', compact('publishIQVQuestion'));
    }

    /**
     * @param \App\Http\Requests\Survey\PublishIQVQuestionUpdateRequest $request
     * @param \App\Models\Survey\PublishIQVQuestion $publishIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(PublishIQVQuestionUpdateRequest $request, PublishIQVQuestion $publishIQVQuestion)
    {
        $publishIQVQuestion->update($request->validated());

        $request->session()->flash('publishIQVQuestion.id', $publishIQVQuestion->id);

        return redirect()->route('publishIQVQuestion.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\PublishIQVQuestion $publishIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PublishIQVQuestion $publishIQVQuestion)
    {
        $publishIQVQuestion->delete();

        return redirect()->route('publishIQVQuestion.index');
    }

    /**
     * @param \App\Http\Requests\Survey\PublishIQVQuestionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublishIQVQuestionStoreRequest $request)
    {
        $publishIQV = PublishIQV::create($request->validated());

        $request->session()->flash('publishIQV.created-successfully', $publishIQV->created-successfully);

        return redirect()->route('Survey\PublishIQVQuestion.index');
    }
}
