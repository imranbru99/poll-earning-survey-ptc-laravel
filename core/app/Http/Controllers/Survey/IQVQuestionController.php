<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\IQVQuestionStoreRequest;
use App\Http\Requests\Survey\IQVQuestionUpdateRequest;
use App\Models\Survey\iQVQuestion;
use Illuminate\Http\Request;

class IQVQuestionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iQVQuestions = IQVQuestion::all();

        return view('iQVQuestion.index', compact('iQVQuestions'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('iQVQuestion.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey\iQVQuestion $iQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, IQVQuestion $iQVQuestion)
    {
        return view('iQVQuestion.show', compact('iQVQuestion'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey\iQVQuestion $iQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, IQVQuestion $iQVQuestion)
    {
        return view('iQVQuestion.edit', compact('iQVQuestion'));
    }

    /**
     * @param \App\Http\Requests\Survey\IQVQuestionUpdateRequest $request
     * @param \App\Survey\iQVQuestion $iQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(IQVQuestionUpdateRequest $request, IQVQuestion $iQVQuestion)
    {
        $iQVQuestion->update($request->validated());

        $request->session()->flash('iQVQuestion.id', $iQVQuestion->id);

        return redirect()->route('iQVQuestion.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey\iQVQuestion $iQVQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IQVQuestion $iQVQuestion)
    {
        $iQVQuestion->delete();

        return redirect()->route('iQVQuestion.index');
    }

    /**
     * @param \App\Http\Requests\Survey\IQVQuestionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IQVQuestionStoreRequest $request)
    {
        $ivqQuestion = IvqQuestion::create($request->validated());

        $request->session()->flash('IvqQuestion.created-successfully', $IvqQuestion->created-successfully);

        return redirect()->route('Survey\IQVQuestion.index');
    }
}
