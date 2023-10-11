<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use App\Log;

class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $subscribers = Subscriber::where('first_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('email', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('subscribers.index', compact('subscribers'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $subscriber = Subscriber::findOrFail($id);
        Subscriber::where('id', $id)->delete();
        Log::createLog('Deleted a subscriber - '.$subscriber->email);
        return response()->json(1);
    }
    
    public function subscribeNow(Request $request) {
    	$email = $request->email;
        $first_name = $request->first_name ?? null;
        $last_name = $request->last_name ?? null;
        $contact_number = $request->contact_number ?? null;
        if (is_null($first_name) || is_null($last_name)) {
            return response()->json('Please enter your name', 500);
        }
    	if ($email == '' || !strpos($email, '@')) {
    		return response()->json('Please enter a valid email address', 500);
    	} else {
    		$exist = Subscriber::where('email', $email)->first();
    		if ($exist) {
    			Subscriber::where('id', $exist->id)->update([
                    'subscribed' => 1,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'contact_number' => $contact_number
                ]);
    		} else {
    			Subscriber::insert([
                    'email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'contact_number' => $contact_number
                ]);
    		}
    	}
    	return response()->json(1);
    }
}
