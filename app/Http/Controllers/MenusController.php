<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Log;
use Str;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $menus = Menu::where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('menus.index', compact('menus', 'keyword'));
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
		$type = $request->type;

        $id = Menu::insertGetId([
	            'name' => $name,
	            'description' => $description,
	            'type' => $type,
	            'created_by' => $user->id,
	            'updated_by' => $user->id
	        ]);
        Log::createLog('Added new menu - '.$name);
        $menu = Menu::find($id);
        return response()->json([
            'id' => $id,
            'name' => Str::limit($menu->name, 50, $end = '...'),
            'description' => Str::limit($menu->description, 200, $end = '...'),
            'type' => $type == 1 ? 'Food' : 'Beverage',
            'updated_by' => $menu->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($menu->updated_at))
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
        $menu = Menu::findOrFail($id);
        return response()->json([
            'name' => Str::limit($menu->name, 50, $end = '...'),
            'description' => $menu->description,
            'type' => $menu->type
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
        $name = $request->name;
		$description = $request->description;
		$type = $request->type;

        $menu = Menu::findOrFail($id);
        Menu::where('id', $id)
        ->update([
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'updated_by' => $user->id
        ]);
        Log::createLog('Updated a menu - '.$name);
        $menu = Menu::find($id);
        return response()->json([
            'id' => $id,
            'name' => Str::limit($menu->name, 50, $end = '...'),
            'description' => Str::limit($menu->description, 200, $end = '...'),
            'type' => $type == 1 ? 'Food' : 'Beverage',
            'updated_by' => $menu->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($menu->updated_at))
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
        $menu = Menu::findOrFail($id);
        Menu::where('id', $id)->delete();
        Log::createLog('Deleted a menu - '.$menu->name);
        return response()->json(1);
    }
}
