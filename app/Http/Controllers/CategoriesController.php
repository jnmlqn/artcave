<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Log;
use Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $categories = Category::where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('categories.index', compact('categories', 'keyword'));
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
        $name = $request->name;
        $description = $request->description;

        $id = Category::insertGetId([
                'name' => $name,
                'description' => $description,
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]);
        Log::createLog('Added new category - '.$name);
        $category = Category::find($id);
        return response()->json([
            'id' => $id,
            'name' => $category->name,
            'description' => $category->description,
            'updated_by' => $category->updatedBy->name. '<br>' .date('F d, Y, h:i:s A', strtotime($category->updated_at))
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
        $category = Category::findOrFail($id);
        return response()->json($category);
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
        $name = $request->name;
        $description = $request->description;

        $category = Category::findOrFail($id);

        Category::where('id', $id)->update([
            'name' => $name,
            'description' => $description
        ]);
        Log::createLog('Updated a category - '.$name);
        $category = Category::find($id);
        return response()->json([
            'id' => $id,
            'name' => $category->name,
            'description' => $category->description,
            'updated_by' => $category->updatedBy->name. '<br>' .date('M d, Y, h:i:s A', strtotime($category->updated_at))
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
        $category = Category::findOrFail($id);
        Category::where('id', $id)->delete();
        Log::createLog('Deleted a promo/event - '.$category->name);
        return response()->json(1);
    }
}
