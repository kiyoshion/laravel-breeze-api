<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flash;
use App\Models\Material;
use App\Models\User;

class UserWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $name)
    {
        $user = User::select(['id', 'name', 'displayname', 'avatar'])->where('name', '=', $name)->first();

        $materials = Flash::select('materials.id', 'materials.title', 'materials.thumbnail')
            ->where('flashes.user_id', '=', $user->id)
            ->join('materials', 'flashes.material_id', 'materials.id')
            ->groupBy('materials.id', 'materials.title', 'materials.thumbnail')
            ->get();

        $thumbs = [];

        foreach ($materials as $i => $material) {
            $flashes = Flash::select('front_image_small', 'back_image_small')->where('material_id', $material->id)->where(function ($query) {
                $query->whereNotNull('front_image_small')->orWhereNotNull('back_image_small');
            })->orderByDesc('created_at')->limit(3)->get();
            foreach ($flashes as $flash) {
                if ($flash->front_image_small) {
                    $thumbs[] = $flash->front_image_small;
                } elseif ($flash->back_image_small) {
                    $thumbs[] = $flash->back_image_small;
                }
            }
            $materials[$i]->thumbs = $thumbs;
            $thumbs = [];
        }

        return response()->json([
            'user' => $user,
            'materials' => $materials,
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
    public function show(Request $request, $name, $id)
    {
        $user = User::select(['id', 'name', 'displayname', 'avatar'])->where('name', '=', $name)->first();

        $flashes = Flash::where('flashes.user_id', '=', $user->id)
            ->where('flashes.material_id', '=', $id)
            ->orderByDesc('flashes.created_at')
            ->limit(10)
            ->get();

        $material = Material::select(['id', 'title'])->where('id', $id)->first();

        return response()->json([
            'user' => $user,
            'flashes' => $flashes,
            'material' => $material,
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
