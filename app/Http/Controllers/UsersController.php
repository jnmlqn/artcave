<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Log;
use App\AccessLevel;
use Str;
use Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $levels = AccessLevel::get();
        $users = User::where('first_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('email', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('users.index', compact('users', 'levels', 'keyword'));
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
        $first_name = $request->first_name;
        $middle_name = $request->middle_name;
        $last_name = $request->last_name;
        $extension = $request->extension;
        $email = $request->email;
        $address = $request->address ?? '';
        $access_level_id = $request->access_level_id;

        $id = 'U-'.time();

        User::insert([
            'id' => $id,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'extension' => $extension,
            'email' => $email,
            'password' => bcrypt(strtolower($last_name)),
            'address' => $address,
            'access_level_id' => $access_level_id,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);
        $new_user = User::find($id);
        Log::createLog('Added new user - '.$new_user->name);
        return response()->json([
            'id' => $id,
            'name' => $new_user->name,
            'email' => $new_user->email,
            'address' => $new_user->address,
            'access_level' => $new_user->accessLevelId->level,
            'updated_by' => $new_user->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($new_user->updated_at))
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
        $new_user = User::findOrFail($id);
        return response()->json([
            'first_name' => $new_user->first_name,
            'middle_name' => $new_user->middle_name,
            'last_name' => $new_user->last_name,
            'extension' => $new_user->extension,
            'email' => $new_user->email,
            'address' => $new_user->address,
            'access_level_id' => $new_user->access_level_id,
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
        $first_name = $request->first_name;
        $middle_name = $request->middle_name;
        $last_name = $request->last_name;
        $extension = $request->extension;
        $email = $request->email;
        $address = $request->address ?? '';
        $access_level_id = $request->access_level_id;

        $new_user = User::findOrFail($id);
        User::where('id', $id)
        ->update([
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'extension' => $extension,
            'email' => $email,
            'address' => $address,
            'access_level_id' => $access_level_id,
            'updated_by' => $user->id
        ]);
        $new_user = User::find($id);
        Log::createLog('Updated a user - '.$new_user->name);
        return response()->json([
            'id' => $id,
            'name' => $new_user->name,
            'email' => $new_user->email,
            'address' => $new_user->address,
            'access_level' => $new_user->accessLevelId->level,
            'updated_by' => $new_user->updatedBy->name. ', ' .date('F d, Y, h:i:s A', strtotime($new_user->updated_at))
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
        $new_user = User::findOrFail($id);
        User::where('id', $id)->delete();
        Log::createLog('Deleted a user - '.$new_user->name);
        return response()->json(1);
    }

    public function changePassword(Request $request) {
        $user = $request->user();
        $old = $request->old;
        $new = $request->new;
        $confirm = $request->confirm;

        if (Hash::check($old, $user->password)) {
            if ($new== $confirm) {
                User::where('id', $user->id)->update(['password' => bcrypt($new)]);
                return response()->json(1);
            } else {
                return response()->json('The new password and confirmation password do not match', 500);
            }
        } else {
            return response()->json('Invalid old password', 500);
        }
    }
}
