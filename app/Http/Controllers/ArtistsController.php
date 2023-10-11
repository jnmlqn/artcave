<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;
use App\Log;
use Str;
use Storage;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $artists = Artist::where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('artists.index', compact('artists', 'keyword'));
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
        $artist_name = $request->artist_name;
        $description = $request->description;
        $image = $request->image ?? null;

        $id = 'A-'.time();

        if (!is_null($image)) {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/artists/'.$name, base64_decode($image));
            $path = 'storage/app/public/artists/'.$name;
        } else {
            return response()->json("Please upload the artist image", 500);
        }

        Artist::insert([
            'id' => $id,
            'name' => $artist_name,
            'description' => $description,
            'image' => $path ?? null,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);
        Log::createLog('Added new artist - '.$artist_name);
        $artist = Artist::find($id);
        return response()->json([
            'id' => $id,
            'name' => $artist->name,
            'description' => $artist->description,
            'image' => $artist->image,
            'updated_by' => $artist->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($artist->updated_at))
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
        $artist = Artist::findOrFail($id);
        return response()->json($artist);
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
        $artist_name = $request->artist_name;
        $description = $request->description;
        $image = $request->image ?? null;

        $artist = Artist::findOrFail($id);

        if (is_null($image)) {
            $data = [
                'name' => $artist_name,
                'description' => $description,
                'updated_by' => $user->id
            ];
        } else {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/artists/'.$name, base64_decode($image));
            $path = 'storage/app/public/artists/'.$name;
            $data = [
                'name' => $artist_name,
                'description' => $description,
                'image' => $path,
                'updated_by' => $user->id
            ];
        }
        Artist::where('id', $id)->update($data);
        Log::createLog('Updated an artist - '.$artist_name);
        $artist = Artist::find($id);
        return response()->json([
            'id' => $id,
            'name' => $artist->name,
            'description' => $artist->description,
            'image' => $artist->image,
            'updated_by' => $artist->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($artist->updated_at))
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
        $artist = Artist::findOrFail($id);
        Artist::where('id', $id)->delete();
        Log::createLog('Deleted an artist - '.$artist->name);
        return response()->json(1);
    }

    public function searchIndex() {
        $user = request()->user();
        $keyword = request()->keyword;
        $artists = Artist::where('name', 'LIKE', '%'.$keyword.'%')
                    ->select('id', 'name')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);
        return response()->json($artists);
    }
}
