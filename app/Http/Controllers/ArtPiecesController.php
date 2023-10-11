<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArtPiece;
use App\Category;
use App\Log;
use Str;
use Storage;

class ArtPiecesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $categories = Category::select('id','name')->get();
        $art_pieces = ArtPiece::where('title', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('art_pieces.index', compact('art_pieces', 'categories', 'keyword'));
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
        $artist_id = $request->artist_id;
        $category_id = $request->category_id;
        $description = $request->description;
        $specification = $request->specification;
        $image = $request->image ?? null;
        $sold = $request->sold ?? 0;

        $id = 'AP-'.time();

        if (!is_null($image)) {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/art_pieces/'.$name, base64_decode($image));
            $path = 'storage/app/public/art_pieces/'.$name;
        } else {
            return response()->json("Please upload the art piece image", 500);
        }

        ArtPiece::insert([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'image' => $path ?? null,
            'category_id' => $category_id,
            'artist_id' => $artist_id,
            'specification' => $specification,
            'sold' => $sold,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);
        Log::createLog('Added new art piece - '.$title);
        $piece = ArtPiece::find($id);
        return response()->json([
            'id' => $id,
            'title' => $piece->title,
            'description' => Str::limit($piece->description, 200, $end = '...'),
            'image' => $piece->image,
            'category_name' => $piece->categoryId->name ?? 'N/A',
            'artist' => $piece->artistId->name,
            'sold' => $sold,
            'updated_by' => $piece->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($piece->updated_at))
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
        $piece = ArtPiece::findOrFail($id);
        return response()->json([
            'title' => $piece->title,
            'description' => $piece->description,
            'specification' => $piece->specification,
            'image' => $piece->image,
            'category' => $piece->category_id,
            'category_name' => $piece->categoryId->name ?? 'N/A',
            'sold' => $piece->sold,
            'artist' => $piece->artistId,
        ]);
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
        $artist_id = $request->artist_id;
        $category_id = $request->category_id;
        $description = $request->description;
        $specification = $request->specification;
        $image = $request->image ?? null;
        $sold = $request->sold ?? 0;

        $piece = ArtPiece::findOrFail($id);

        if (is_null($image)) {
            $data = [
                'title' => $title,
                'description' => $description,
                'category_id' => $category_id,
                'artist_id' => $artist_id,
                'specification' => $specification,
                'sold' => $sold,
                'updated_by' => $user->id
            ];
        } else {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/art_pieces/'.$name, base64_decode($image));
            $path = 'storage/app/public/art_pieces/'.$name;
            $data = [
                'title' => $title,
                'description' => $description,
                'image' => $path,
                'category_id' => $category_id,
                'artist_id' => $artist_id,
                'specification' => $specification,
                'sold' => $sold,
                'updated_by' => $user->id
            ];
        }
        ArtPiece::where('id', $id)->update($data);
        Log::createLog('Updated an art piece - '.$title);
        if ($sold == 1) {
            Log::createLog('Marked as sold - '.$title);
        }
        $piece = ArtPiece::find($id);
        return response()->json([
            'id' => $id,
            'title' => $piece->title,
            'description' => Str::limit($piece->description, 200, $end = '...'),
            'image' => $piece->image,
            'category_name' => $piece->categoryId->name ?? 'N/A',
            'artist' => $piece->artistId->name,
            'sold' => $sold,
            'updated_by' => $piece->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($piece->updated_at))
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
        $piece = ArtPiece::findOrFail($id);
        ArtPiece::where('id', $id)->delete();
        Log::createLog('Deleted an art piece - '.$piece->title);
        return response()->json(1);
    }
}
