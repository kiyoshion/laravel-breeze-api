<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Flash;
use App\Models\Join;
use App\Models\Memo;
use Auth;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user() && Join::where('user_id', Auth::id())->exists()) {
            $topic_id = Join::select(['topic_id'])->where('user_id', Auth::id())->first();

            $memos = Memo::with(['user:id,name,avatar,displayname'])
            ->where('chapter_id', $id)
            ->where('topic_id', $topic_id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

            $flashes = Flash::with(['user:id,name,avatar,displayname'])
            ->where('chapter_id', $id)
            ->where('topic_id', $topic_id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

            $chapter = Chapter::with(['memos.user:id,name,avatar,displayname', 'flashes.user:id,name,avatar,displayname', 'content.material'])
            ->findOrFail($id);

            $chapter['memos'] = $memos;
            $chapter['flashes'] = $flashes;
        } else {
            $chapter = Chapter::with(['memos.user:id,name,avatar,displayname', 'flashes.user:id,name,avatar,displayname', 'content.material'])->findOrFail($id);
        }


        return response()->json([
            'chapter' => $chapter
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
