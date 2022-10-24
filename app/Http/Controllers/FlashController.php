<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Flash;
use App\Models\Material;
use Auth;

class FlashController extends Controller
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
        $flash = Flash::firstOrCreate([
            'id' => uniqid(),
            'front_title' => $request->input('front_title'),
            'front_description' => $request->input('front_description'),
            'back_title' => $request->input('back_title'),
            'back_description' => $request->input('back_description'),
            'material_id' => $request->input('material_id'),
            'chapter_id' => $request->input('chapter_id'),
            'topic_id' => $request->input('topic_id'),
            'user_id' => Auth::id(),
        ]);

        $file_path = 'img/flashes/' . $flash->id . '/';

        if ($request->front_image) {
            $file_front_name_small = date('YmdHis') . uniqid() . '-small.jpg';
            $file_front_name_medium = date('YmdHis') . uniqid() . '-medium.jpg';
            $file_front_name_large = date('YmdHis') . uniqid() . '-large.jpg';

            $front_image = $request->front_image;
            $front_image = str_replace('data:image/jpeg;base64,', '', $front_image);
            $front_image = str_replace(' ', '+', $front_image);

            // small
            $front_image_data_small = \Image::make(base64_decode($front_image));
            $front_image_data_small->orientate();
            $front_image_data_small->fit(80, 80);
            Storage::disk('public')->put($file_path . $file_front_name_small, $front_image_data_small->stream());

            // medium
            $front_image_data_medium = \Image::make(base64_decode($front_image));
            $front_image_data_medium->orientate();
            $front_image_data_medium->resize(400, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($file_path . $file_front_name_medium, $front_image_data_medium->stream());

            // large
            $front_image_data_large = \Image::make(base64_decode($front_image));
            $front_image_data_large->orientate();
            $front_image_data_large->resize(null, 1080, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($file_path . $file_front_name_large, $front_image_data_large->stream());

            $flash->front_image_small = $file_path . $file_front_name_small;
            $flash->front_image_medium = $file_path . $file_front_name_medium;
            $flash->front_image_large = $file_path . $file_front_name_large;
            $flash->save();
        }

        if ($request->back_image) {
            $file_back_name_small = date('YmdHis') . uniqid() . '-small.jpg';
            $file_back_name_medium = date('YmdHis') . uniqid() . '-medium.jpg';
            $file_back_name_large = date('YmdHis') . uniqid() . '-large.jpg';

            $back_image = $request->back_image;
            $back_image = str_replace('data:image/jpeg;base64,', '', $back_image);
            $back_image = str_replace(' ', '+', $back_image);

            // small
            $back_image_data_small = \Image::make(base64_decode($back_image));
            $back_image_data_small->orientate();
            $back_image_data_small->fit(80, 80);
            Storage::disk('public')->put($file_path . $file_back_name_small, $back_image_data_small->stream());

            // medium
            $back_image_data_medium = \Image::make(base64_decode($back_image));
            $back_image_data_medium->orientate();
            $back_image_data_medium->resize(400, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($file_path . $file_back_name_medium, $back_image_data_medium->stream());

            // large
            $back_image_data_large = \Image::make(base64_decode($back_image));
            $back_image_data_large->orientate();
            $back_image_data_large->resize(null, 1080, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::disk('public')->put($file_path . $file_back_name_large, $back_image_data_large->stream());

            $flash->back_image_small = $file_path . $file_back_name_small;
            $flash->back_image_medium = $file_path . $file_back_name_medium;
            $flash->back_image_large = $file_path . $file_back_name_large;
            $flash->save();
        }

        return response()->json([
            'material' => Material::with(['user:id,name', 'sections', 'contents.chapters', 'topics', 'joins.user:id,name,avatar', 'memos.user:id,name,avatar,displayname', 'flashes.user:id,name,avatar,displayname'])->findOrFail($request->input('material_id'))
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
