<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medium;
use App\Log;
use Str;
use Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $media = Medium::where('title', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('media.index', compact('media', 'keyword'));
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
        $user = $request->user();
        $title = $request->title;
        $description = $request->description;
        $link = $request->link;
        $media_type = $request->media_type;
        $image = $request->image ?? null;

        $id = 'M-'.time();

        if (!is_null($image)) {
            $size = getimagesize($image);
            // if ($size[0] !== 200 && $size[1] !== 200) {
            //     return response()->json('Image size must be 200x200 pixels', 500);
            // }
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/media/'.$name, base64_decode($image));
            $path = 'storage/app/public/media/'.$name;
        } else {
            return response()->json("Please upload a valid thumbnail", 500);
        }

        Medium::insert([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'link' => $link,
            'media_type' => $media_type,
            'thumbnail' => $path ?? null,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);
        Log::createLog('Added new media - '.$title);
        $media = Medium::find($id);
        return response()->json([
            'id' => $id,
            'title' => $media->title,
            'description' => $media->description,
            'thumbnail' => $media->thumbnail,
            'link' => $media->link,
            'updated_by' => $media->updatedBy->name. '<br>' .date('F d, Y, h:i:s A', strtotime($media->updated_at))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Medium::findOrFail($id);
        return response()->json($media);
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
        $user = $request->user();
        $title = $request->title;
        $description = $request->description;
        $link = $request->link;
        $media_type = $request->media_type;
        $image = $request->image ?? null;

        $media = Medium::findOrFail($id);

        if (is_null($image)) {
            $data = [
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'media_type' => $media_type,
                'updated_by' => $user->id
            ];
        } else {
            $size = getimagesize($image);
            // if ($size[0] !== 800 && $size[1] !== 800) {
            //     return response()->json('Image size must be 800x800 pixels', 500);
            // }
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/media/'.$name, base64_decode($image));
            $path = 'storage/app/public/media/'.$name;
            $data = [
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'media_type' => $media_type,
                'thumbnail' => $path,
                'updated_by' => $user->id
            ];
        }
        Medium::where('id', $id)->update($data);
        Log::createLog('Updated a media - '.$title);
        $media = Medium::find($id);
        return response()->json([
            'id' => $id,
            'title' => $media->title,
            'description' => $media->description,
            'thumbnail' => $media->thumbnail,
            'link' => $media->link,
            'updated_by' => $media->updatedBy->name. '<br>' .date('F d, Y, h:i:s A', strtotime($media->updated_at))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();
        $media = Medium::findOrFail($id);
        Medium::where('id', $id)->delete();
        Log::createLog('Deleted a media - '.$media->title);
        return response()->json(1);
    }
}
