<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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
        $file_result_path = '';
        $file_name = date('YmdHis') . $id . '.jpg';
        $file_path = 'img/user/' . $id . '/';

        $user = User::findOrFail($id);

        if ($request->avatar) {
            $avatar = $request->avatar;
            $avatar = str_replace('data:image/jpeg;base64,', '', $avatar);
            $avatar = str_replace(' ', '+', $avatar);

            $avatar_image = \Image::make(base64_decode($avatar))->fit(80, 80);

            $files = Storage::disk('public')->allFiles($file_path);
            if (count($files) > 0) {
                foreach($files as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            Storage::disk('public')->put($file_path . $file_name, $avatar_image->stream());
            $user->avatar = $file_path . $file_name;
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
}
