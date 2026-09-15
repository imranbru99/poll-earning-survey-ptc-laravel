<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\AttemptIQVQuestionStoreRequest;
use App\Http\Requests\Survey\AttemptIQVQuestionUpdateRequest;
use App\Models\Survey\AttemptIQVQuestion;
use Illuminate\Http\Request;

class AttemptIQVQuestionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attemptIQVQuestions = AttemptIQVQuestion::all();

        return view('attemptIQVQuestion.index', compact('attemptIQVQuestions'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('attemptIQVQuestion.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\AttemptIQVQuestion $attemptIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AttemptIQVQuestion $attemptIQVQuestion)
    {
        return view('attemptIQVQuestion.show', compact('attemptIQVQuestion'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\AttemptIQVQuestion $attemptIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AttemptIQVQuestion $attemptIQVQuestion)
    {
        return view('attemptIQVQuestion.edit', compact('attemptIQVQuestion'));
    }

    /**
     * @param \App\Http\Requests\Survey\AttemptIQVQuestionUpdateRequest $request
     * @param \App\Models\Survey\AttemptIQVQuestion $attemptIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(AttemptIQVQuestionUpdateRequest $request, AttemptIQVQuestion $attemptIQVQuestion)
    {
        $attemptIQVQuestion->update($request->validated());

        $request->session()->flash('attemptIQVQuestion.id', $attemptIQVQuestion->id);

        return redirect()->route('attemptIQVQuestion.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\AttemptIQVQuestion $attemptIQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AttemptIQVQuestion $attemptIQVQuestion)
    {
        $attemptIQVQuestion->delete();

        return redirect()->route('attemptIQVQuestion.index');
    }

    /**
     * @param \App\Http\Requests\Survey\AttemptIQVQuestionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttemptIQVQuestionStoreRequest $request)
    {
        $attemptIqvTest = AttemptIqvTest::create($request->validated());

        $request->session()->flash('AttemptIqvTest.created-successfully', $AttemptIqvTest->created-successfully);

        return redirect()->route('Survey\AttemptIQVQuestion.show', ['Survey\AttemptIQVQuestion' => $Survey\AttemptIQVQuestion]);
    }
}
