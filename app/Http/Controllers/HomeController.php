<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Flash;
use App\Models\Join;
use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $joins = Join::select(['material_id', 'topic_id'])->with(['topic:id,name'])->where('user_id', Auth::id())->orderByDesc('created_at')->get();

        $material_ids = [];
        foreach($joins as $m) {
            $material_ids[] = $m['material_id'];
        }

        $materials = Material::with(['joins.topic', 'type:id,name'])->whereIn('id', $material_ids)->get();

        $flashes = Flash::join('materials', 'flashes.material_id', '=', 'materials.id')
        ->join('topics', 'flashes.topic_id', '=', 'topics.id')
        ->select([
            'flashes.id as flash_id',
            'flashes.front_title as flash_front_title',
            'materials.id as material_id',
            'materials.title as material_title',
            'materials.thumbnail as material_thumbnail',
            'topics.name as topic_name'
        ])
        ->where('flashes.user_id', Auth::id())
        ->orderByDesc('flashes.created_at')
        ->get();

        return response()->json([
            'joins' => $joins,
            'materials' => $materials,
            'flashes' => $flashes
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
