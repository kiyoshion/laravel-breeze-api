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

// require __DIR__ . 'vendor/autoload.php';
use GuzzleHttp\Client;

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
                ->with(['type:id,name'])
                ->limit(12)
                ->orderBy('title')
                ->get();
        } else {
            $materials = Material::with(['type:id,name'])
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
        $material = new Material();
        $material->id = uniqid();
        $material->title = $request->title;
        $material->user_id = Auth::id();
        $material->type_id = $request->type_id;
        $material->save();

        $file_name = date('YmdHis') . uniqid() . '.jpg';
        $file_path = 'img/materials/';

        if ($request->poster) {
            $poster = \Image::make($request->file('poster')->getRealPath())->fit(360, 480);

            Storage::disk('public')->put($file_path . $file_name, (string) $poster->encode('jpg', 80));

            $material->poster = $file_path . $file_name;

            $thumbnail = \Image::make($request->file('poster')->getRealPath())->resize(null, 160, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $bin = base64_encode($thumbnail->encode('jpeg'));

            $material->thumbnail = $bin;
            $material->save();
        }

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
            'material' => Material::with(['contents.chapters', 'user:id,name', 'type:id,name'])->findOrFail($material->id)
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
            'material' => Material::with(['user:id,name', 'sections', 'contents.chapters', 'topics', 'joins.user:id,name,avatar', 'memos.user:id,name,avatar,displayname', 'flashes.user:id,name,avatar,displayname', 'type:id,name,label_contents,label_chapters'])->findOrFail($id)
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
        // $client = new Client();
        // $response = $client->request('GET', $request->url);
        // $html = $response->getBody()->getContents();
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $html = file_get_contents($request->url);
        $html = mb_convert_encoding($html, "HTML-ENTITIES", 'auto');
        @$dom->loadHTML($html);
        $xpath = new \DOMXpath($dom);
        $nodes = $xpath->query('//*[contains(@class, "section")]');

        $contents = [];
        foreach($nodes as $node) {
            $contents[] = $node->nodeValue;
        }

        return response()->json([
            'html' => $html,
            'contents' => $contents
        ], 200);

        // $client = new Client(['stream' => true]);
        // $response = $client->request('GET', 'https://google.com/search?q=' . $request->input('query') . '&tbm=isch&tbs=isz:l');
        // $html = $response->getBody()->getContents();
        // $document = new \DOMDocument();
        // @$document->loadHTML($html);
        // $xpath = new \DOMXpath($document);
        // $nodes = $xpath->query('//body//img');

        // $imgs = [];
        // foreach ($nodes as $node) {
        //     $imgs[] = $node->getAttribute('src');
        // }

        // return $imgs;
    }
}
