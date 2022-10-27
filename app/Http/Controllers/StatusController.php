<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Material;
use Auth;

class StatusController extends Controller
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
        if ($request->value === 'now') {
            $status_nows = Status::where('material_id', '=', $request->material_id)
            ->where('user_id', '=', Auth::id())
            ->where('value', '=', 'now')
            ->get();

            foreach($status_nows as $status) {
                $status->value = 'pause';
                $status->update();
            }
        }

        $status = Status::updateOrCreate([
            'chapter_id' => $request->chapter_id,
            'user_id' => Auth::id()
        ],[
            'value' => $request->value,
            'material_id' => $request->material_id,
        ]);

        return response()->json([
            'material' => Material::with([
                'user:id,name',
                'contents.chapters',
                'topics',
                'joins.user:id,name,avatar,displayname',
                'memos.user:id,name,avatar,displayname',
                'flashes.user:id,name,avatar,displayname',
                'type:id,name,label_contents,label_chapters',
            ])->findOrFail($request->material_id)
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
        //
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
