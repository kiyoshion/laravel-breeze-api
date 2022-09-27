<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Section;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'materials' => Material::with('user:id,name')->orderBy('created_at', 'desc')->take(10)->get()
        ]);
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
        $material = Material::firstOrCreate([
            'id' => $uuid,
            'title' => $request->input('title'),
            'user_id' => $request->input('user_id'),
        ]);

        if ($request->input('sections')) {
            $sections = $request->input('sections');
            $i = 0;
            foreach($sections as $sec) {
                $uuid = uniqid();
                $parent_id = 0;
                $order = $i;
                $level = 1;
                if (!$sec[$i]['parent_id'] == 0) {
                    $parent_id = $material->id;
                    $level = 2;
                }
                $section = Section::firstOrCreate([
                    'id' => $uuid,
                    'title' => $sec[$i]['title'],
                    'level' => $level,
                    'order' => $order,
                    'parent_id' => $parent_id,
                ]);
                $i++;
            }
        }

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
        return response()->json([
            'material' => Material::with('user:id,name')->findOrFail($id)
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
