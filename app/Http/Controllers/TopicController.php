<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Join;
use App\Models\Material;
use Auth;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::where('lang', 'ja')->limit(50)->get();
        // $topics = Topic::orderByDesc('joinsCount')->limit(10)->get();

        return response()->json([
            'topics' => $topics
        ], 200);
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
        $topic = Topic::firstOrCreate([
            'name' => $request->input('name')
        ], [
            'id' => uniqid(),
            'name' => $request->input('name'),
            'lang' => $request->input('lang'),
        ]);

        $topic->materials()->syncWithoutDetaching($request->input('material_id'));

        $join = Join::firstOrCreate([
            'user_id' => Auth::id(),
            'material_id' => $request->input('material_id')
        ], [
            'user_id' => Auth::id(),
            'material_id' => $request->input('material_id'),
            'topic_id' => $topic->id,
        ]);

        $material = Material::with(['user:id,name', 'sections', 'topics', 'joins.user:id,name,avatar', 'type:id,name,label_contents,label_chapters'])->findOrFail($request->input('material_id'));

        return response()->json([
            'material' => $material
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::with(['materials'])->findOrFail($id);

        return response()->json([
            'topic' => $topic
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
