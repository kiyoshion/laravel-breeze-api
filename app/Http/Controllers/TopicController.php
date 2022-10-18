<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Join;

class TopicController extends Controller
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
        $uuid = uniqid();
        $topic = Topic::firstOrCreate([
            'name' => $request->input('name')
        ], [
            'id' => $uuid,
            'name' => $request->input('name'),
            'lang' => $request->input('lang'),
        ]);

        $topic->materials()->syncWithoutDetaching($request->input('material_id'));

        $join = Join::firstOrCreate([
            'user_id' => $request->input('user_id'),
            'material_id' => $request->input('material_id')
        ], [
            'user_id' => $request->input('user_id'),
            'material_id' => $request->input('material_id'),
            'topic_id' => $topic->id,
        ]);

        return response()->json([
            'topic' => $topic
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
