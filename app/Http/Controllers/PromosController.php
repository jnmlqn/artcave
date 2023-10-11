<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use App\Log;
use App\Subscriber;
use Str;
use Storage;
use Mail;

class PromosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->keyword;
        $promos = Promo::where('title', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(30);

        return view('promos.index', compact('promos', 'keyword'));
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
        $expiration_date = $request->expiration_date ?? null;
        $send_subscribers = $request->send_subscribers ?? 0;
        $image = $request->image ?? null;

        $id = 'PE-'.time();

        if (!is_null($image)) {
            // $size = getimagesize($image);
            // if ($size[0] !== 800 && $size[1] !== 800) {
            //     return response()->json('Image size must be 800x800 pixels', 500);
            // }
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/promos/'.$name, base64_decode($image));
            $path = 'storage/app/public/promos/'.$name;
        } else {
            return response()->json("Please upload a valid image", 500);
        }

        Promo::insert([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'image' => $path,
            'expiration_date' => $expiration_date,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ]);
        Log::createLog('Added new promo/event - '.$title);
        $promo = Promo::find($id);
        if ($send_subscribers == 1) {
            $subscribers = Subscriber::where('subscribed', 1)->get();
            foreach ($subscribers as $key => $value) {
                $data = [
                    'first_name' => Str::ucfirst($value->first_name),
                    'last_name' => Str::ucfirst($value->last_name),
                    'image' => $path,
                    'id' => $id
                ];
                Mail::send('email.promos', $data, function($message) use ($title, $value) {
                    $message->to($value->email)
                    ->subject($title)
                    ->from('info@artcavegallery.com', 'ArtCave Gallery');
                });
            }
        }
        return response()->json([
            'id' => $id,
            'title' => $promo->title,
            'description' => Str::limit($promo->description, 100, $end = '...'),
            'image' => $promo->image,
            'expiration_date' => $promo->expiration_date ?? 'N/A',
            'updated_by' => $promo->updatedBy->name. '<br>' .date('F d, Y, h:i:s A', strtotime($promo->updated_at))
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
        $promo = Promo::findOrFail($id);
        return response()->json($promo);
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
        $expiration_date = $request->expiration_date ?? null;
        $send_subscribers = $request->send_subscribers ?? 0;
        $image = $request->image ?? null;

        $promo = Promo::findOrFail($id);

        if (is_null($image)) {
            $data = [
                'title' => $title,
                'description' => $description,
                'expiration_date' => $expiration_date,
                'updated_by' => $user->id
            ];
        } else {
            // $size = getimagesize($image);
            // if ($size[0] !== 800 && $size[1] !== 800) {
            //     return response()->json('Image size must be 800x800 pixels', 500);
            // }
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $name = Str::random(10).date('Ymdhis');
            Storage::disk('public')->put('/promos/'.$name, base64_decode($image));
            $path = 'storage/app/public/promos/'.$name;
            $data = [
                'title' => $title,
                'description' => $description,
                'image' => $path,
                'expiration_date' => $expiration_date,
                'updated_by' => $user->id
            ];
        }
        Promo::where('id', $id)->update($data);
        Log::createLog('Updated a promo/event - '.$title);
        $promo = Promo::find($id);
        if ($send_subscribers == 1) {
            $subscribers = Subscriber::where('subscribed', 1)->get();
            foreach ($subscribers as $key => $value) {
                $data = [
                    'first_name' => Str::ucfirst($value->first_name),
                    'last_name' => Str::ucfirst($value->last_name),
                    'image' => $promo->image,
                    'id' => $id
                ];
                Mail::send('email.promos', $data, function($message) use ($title, $value) {
                    $message->to($value->email)
                    ->subject($title)
                    ->from('info@artcavegallery.com', 'ArtCave Gallery');
                });
            }
        }
        return response()->json([
            'id' => $id,
            'title' => $promo->title,
            'description' => Str::limit($promo->description, 100, $end = '...'),
            'image' => $promo->image,
            'expiration_date' => $promo->expiration_date ?? 'N/A',
            'updated_by' => $promo->updatedBy->name. '<br>' .date('F d, Y, h:i:s A', strtotime($promo->updated_at))
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
        $promo = Promo::findOrFail($id);
        Promo::where('id', $id)->delete();
        Log::createLog('Deleted a promo/event - '.$promo->title);
        return response()->json(1);
    }
}
