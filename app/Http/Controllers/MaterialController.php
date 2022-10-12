<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Material;
use App\Models\Section;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('key')) {
            $key = $request->query('key') . '%';
            $materials = Material::where('title', 'LIKE', $key)
                ->with('user:id,name')
                ->limit(12)
                ->orderBy('title')
                ->get();
        } else {
            $materials = Material::with('user:id,name')
                ->orderBy('created_at', 'desc')
                ->take(12)
                ->get();
        }
        return response()->json([
            'materials' => $materials
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
        $uuid = uniqid();
        $file_result_path = '';
        $file_name = date('YmdHis') . $uuid . '.jpg';
        $file_path = 'img/materials/';

        if ($request->file('poster')) {

            $poster = \Image::make($request->file('poster')->getRealPath())->fit(360, 480);

            Storage::disk('public')->put($file_path . $file_name, (string) $poster->encode('jpg', 80));

            $thumbnail = \Image::make($request->file('poster')->getRealPath())->fit(90, 120);

            Storage::disk('public')->put($file_path . 'thumb-' . $file_name, (string) $thumbnail->encode('jpg', 80));

        }

        $material = new Material();
        $material->id = $uuid;
        $material->poster = $file_path . $file_name;
        $material->thumbnail = $file_path . 'thumb-' . $file_name;
        $material->title = $request->input('title');
        $material->user_id = $request->input('user_id');
        $material->save();

        if ($request->input('sections')) {
            $sections = json_decode($request->input('sections'), true);
            $i = 0;
            $parent_id = '';
            foreach($sections as $sec) {
                $uuid = uniqid();
                $order = $i;
                if ($sec['level'] === 1) {
                    $section = Section::firstOrCreate([
                        'id' => $uuid,
                        'title' => $sec['title'],
                        'level' => 1,
                        'order' => $order,
                        'parent_id' => $parent_id,
                        'material_id' => $material->id,
                    ]);
                    $section->parent_id = $parent_id;
                    $section->save();
                } else {
                    $section = Section::firstOrCreate([
                        'id' => $uuid,
                        'title' => $sec['title'],
                        'level' => 0,
                        'order' => $order,
                        'parent_id' => NULL,
                        'material_id' => $material->id,
                    ]);
                    $section->parent_id = $section->id;
                    $section->save();
                    $parent_id = $section->id;
                }
                $i++;
            }
        }

        return response()->json([
            'material' => Material::findOrFail($material->id)->with(['sections', 'users:id,name'])
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
            'material' => Material::with(['user:id,name', 'sections'])->findOrFail($id)
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
