<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\IQVTestStoreRequest;
use App\Http\Requests\Survey\IQVTestUpdateRequest;
use App\Models\Survey\IQVTest;
use Illuminate\Http\Request;

class IQVTestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iQVTests = IQVTest::all();

        return view('iQVTest.index', compact('iQVTests'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('iQVTest.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\IQVTest $iQVTest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, IQVTest $iQVTest)
    {
        return view('iQVTest.show', compact('iQVTest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\IQVTest $iQVTest
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, IQVTest $iQVTest)
    {
        return view('iQVTest.edit', compact('iQVTest'));
    }

    /**
     * @param \App\Http\Requests\Survey\IQVTestUpdateRequest $request
     * @param \App\Models\Survey\IQVTest $iQVTest
     * @return \Illuminate\Http\Response
     */
    public function update(IQVTestUpdateRequest $request, IQVTest $iQVTest)
    {
        $iQVTest->update($request->validated());

        $request->session()->flash('iQVTest.id', $iQVTest->id);

        return redirect()->route('iQVTest.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\IQVTest $iQVTest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IQVTest $iQVTest)
    {
        $iQVTest->delete();

        return redirect()->route('iQVTest.index');
    }

    /**
     * @param \App\Http\Requests\Survey\IQVTestStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IQVTestStoreRequest $request)
    {
        $iqvTest = IqvTest::create($request->validated());

        $request->session()->flash('IqvTest.created-successfully', $IqvTest->created-successfully);

        return redirect()->route('Survey\IQVTest.index');
    }
}
