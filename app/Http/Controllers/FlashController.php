<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Flash;

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
        $uuid = uniqid();

        $flash = Flash::firstOrCreate([
            'id' => $uuid,
            'front_title' => $request->input('front_title'),
            'front_description' => $request->input('front_description'),
            'back_title' => $request->input('back_title'),
            'back_description' => $request->input('back_description'),
            'material_id' => $request->input('material_id'),
            'section_id' => $request->input('section_id'),
            'user_id' => $request->input('user_id'),
        ]);

        $file_name = date('YmdHis') . $request->input('user_id') . '.jpg';
        $file_path = 'img/user/' . $request->input('user_id') . '/flashes/';

        if ($request->front_image) {
            $front_image = $request->front_image;
            $front_image = str_replace('data:image/jpeg;base64,', '', $front_image);
            $front_image = str_replace(' ', '+', $front_image);

            $front_image_data = \Image::make(base64_decode($front_image))->resize(400, null, function($constraint) {
                $constraint->aspectRatio();
            });

            Storage::disk('public')->put($file_path . $file_name, $front_image_data->stream());
            $flash->front_image = $file_path . $file_name;
            $flash->save();
        }

        if ($request->back_image) {
            $back_image = $request->back_image;
            $back_image = str_replace('data:image/jpeg;base64,', '', $back_image);
            $back_image = str_replace(' ', '+', $back_image);

            $back_image_data = \Image::make(base64_decode($back_image))->resize(400, null, function($constraint) {
                $constraint->aspectRatio();
            });

            Storage::disk('public')->put($file_path . $file_name, $back_image_data->stream());
            $flash->back_image = $file_path . $file_name;
            $flash->save();
        }

        return response()->json([
            'flash' => $flash
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
