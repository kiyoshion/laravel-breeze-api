<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Material;
use App\Models\Chapter;
use App\Models\Content;
use App\Models\Section;
use Auth;

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
        $material->id = uniqid();
        $material->poster = $file_path . $file_name;
        $material->thumbnail = $file_path . 'thumb-' . $file_name;
        $material->title = $request->input('title');
        $material->user_id = Auth::id();
        $material->save();

        if ($request->input('contents') && $request->input('chapters')) {
            $contents = json_decode($request->input('contents'), true);
            $chapters = json_decode($request->input('chapters'), true);

            foreach($contents as $content) {
                $order = $content['order'];
                $content = Content::firstOrCreate([
                    'id' => uniqid(),
                    'title' => $content['title'],
                    'order' => $order,
                    'material_id' => $material->id,
                    'user_id' => Auth::id()
                ]);

                foreach($chapters as $chapter) {
                    if ($chapter['parentOrder'] === $order) {
                        $chapter = Chapter::firstOrCreate([
                            'id' => uniqid(),
                            'title' => $chapter['title'],
                            'order' => $chapter['order'],
                            'content_id' => $content->id,
                            'user_id' => Auth::id()
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'material' => Material::with(['contents.chapters', 'user:id,name'])->findOrFail($material->id)
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
            'material' => Material::with(['user:id,name', 'sections', 'contents.chapters', 'topics', 'joins.user:id,name,avatar', 'memos.user:id,name,avatar,displayname'])->findOrFail($id)
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

    public function scrap(Request $request)
    {
        // $url = "https://www.google.com/search?q=" . $request->input('query') . "&tbm=isch";
        // $dom = new \DOMDocument('1.0', 'UTF-8');
        // $html = file_get_contents($url);
        // $html = mb_convert_encoding($html, "HTML-ENTITIES", 'auto');
        // @$dom->loadHTML($html);
        // // $xpath = new \DOMXpath($dom);
        // // $contents = $xpath->query('//img[contains(@src, "jpg")]');
        // $contents = $dom->getElementsByTagName('img');

        // $resutls = [];

        // foreach($contents as $value) {
        //     $resutls[] = $value->ownerDocument->saveXML($value);
        // }

        // return response()->json([
        //     'contents' => $contents,
        //     'results' => $resutls
        // ], 200);

    }
}
