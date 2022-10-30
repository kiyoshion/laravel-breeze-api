<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Flash;
use App\Models\Material;

class UserController extends Controller
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
        $user = User::findOrFail($id);

        if ($request->avatar) {
            $avatar = $request->avatar;

            $avatar_image = \Image::make($avatar)->fit(80, 80);
            $bin = base64_encode($avatar_image->encode('jpeg'));

            $user->avatar = $bin;
            $user->save();
        }

        if ($request->input('profile')) {
            $user->profile = $request->input('profile');
        }

        if ($request->input('displayname')) {
            $user->displayname = $request->input('displayname');
        }

        $user->save();

        return response()->json([
            'user' => $user
        ], 201);
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

    public function showUserWords(Request $request, $name, $id)
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
}
