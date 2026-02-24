<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemo;
use App\Http\Requests\UpdateMemo;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		$this->authorizeResource(Memo::class, 'memo');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$user = $request->user();
		$trashed = $user->memos()->onlyTrashed()->search($request->input('q'));
		$memosWithTrashed = $user->memos()->union($trashed)
        ->search($request->input('q'))->ordered()->paginate(50);
		return view('memos.index')->withMemos($memosWithTrashed);
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
    public function store(StoreMemo $request)
    {
        $validated = $request->validated();
        try {
            $memo = new Memo;
            $memo->content = $validated['content'];
            $memo->user_id = $request->user()->id;
            $memo->save();
            return redirect()->route('memos.index')->withStatus("Success.");
        } catch (\Exception $e) {
            $errors = $e->getMessage();
            return back()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function show(Memo $memo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function edit(Memo $memo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemo $request, Memo $memo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memo $memo)
    {
        try {
            $memo->delete();
            return redirect()->route('memos.index')->withStatus("Success.");
        } catch (\Exception $e) {
            $errors = $e->getMessage();
            return back()->withErrors($errors);
        }
    }
}
