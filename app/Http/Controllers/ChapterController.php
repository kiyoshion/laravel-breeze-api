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
    public function show($id, Request $request)
    {
        if ($request->topic) {

            $chapter = Chapter::join('memos', 'memos.chapter_id', '=', 'chapters.id')
            ->where('memos.chapter_id', $id)
            ->where('memos.topic_id', $request->topic)
            ->orderByDesc('memos.created_at')
            ->limit(10)
            ->join('flashes', 'flashes.chapter_id', '=', 'chapters.id')
            ->where('flashes.chapter_id', $id)
            ->where('flashes.topic_id', $request->topic)
            ->orderByDesc('flashes.created_at')
            ->limit(10)
            ->get();
            
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
