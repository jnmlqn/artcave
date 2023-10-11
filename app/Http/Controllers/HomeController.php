<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use App\Artist;
use App\ArtPiece;
use App\Menu;
use App\Medium;
use App\Category;
use App\Subscriber;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $promos = Promo::where('expiration_date', '>', date('Y-m-d'))
                    ->orWhereNull('expiration_date')
                    ->orderBy('expiration_date', 'ASC')
                    ->limit(3)
                    ->get();
        $artist = Artist::count();
        $artpiece = ArtPiece::count();
        return view('index', compact('promos', 'artist', 'artpiece'));
    }

    public function aboutUs() {
        return view('about-us');
    }

    public function contactUs() {
        return view('contact-us');
    }

    public function theCafe() {
        $foods = Menu::where('type', 1)->get();
        $beverages = Menu::where('type', 2)->get();
        return view('cafe', compact('foods', 'beverages'));
    }

    public function theGallery(Request $request) {
        $categories = Category::get();
        $artist = $request->artist ?? '';
        $filter = $request->filter ?? 2;
        $category = $request->category ?? null;
        $id = request()->id ?? null;

        $artpieces = new ArtPiece();

        if (is_null($id)) {
            if ((int)$filter !== 2) {
                $artpieces = $artpieces->where('sold', $filter);
            }
            if (!is_null($category)) {
                $artpieces = $artpieces->where('category_id', $category);
            }
        } else {
            $artpieces = $artpieces->where('id', $id);
        }

        $artpieces = $artpieces->whereHas('artistId', function($q) use($artist) {
                        $q->where('name', 'LIKE', '%'.$artist.'%');
                    })
                    ->orderBy('created_at', 'DESC')->paginate(9);
        return view('gallery', compact('artpieces', 'filter', 'categories', 'category', 'artist'));
    }

    public function promosEvents() {
        $id = request()->id;    
        $promos = Promo::where(function($q) {
                        $q->where('expiration_date', '>=', date('Y-m-d'))
                        ->orWhereNull('expiration_date');
                    })
                    ->where('id', 'LIKE', '%'.$id.'%')
                    ->orderBy('expiration_date', 'ASC')
                    ->paginate(9);
        return view('promos', compact('promos'));
    }

    public function media() {
        $filter = request()->filter ?? 0;
        $id = request()->id;
        if ($filter == 0) {
            $media = Medium::orderBy('created_at', 'ASC')->paginate(9);
        } else {
            $media = Medium::where('media_type', $filter)->orderBy('created_at', 'ASC')->paginate(9);
        }
        return view('media', compact('media', 'filter'));
    }

    public function inquire(Request $request) {
        $artpiece_id = $request->artpiece_id;
        $artpiece = ArtPiece::find($artpiece_id);

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $contact = $request->contact;
        $address = $request->address;
        $date = $request->date;
        $time = $request->time;
        $message = $request->message;
        $keep_updated = $request->keep_updated ?? 0;

        if ($keep_updated == 1) {
            if ($email !== '' && strpos($email, '@')) {
                $exist = Subscriber::where('email', $email)->first();
                if ($exist) {
                    Subscriber::where('id', $exist->id)->update([
                        'subscribed' => 1,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'contact_number' => $contact,
                    ]);
                } else {
                    Subscriber::insert([
                        'email' => $email,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'contact_number' => $contact,
                    ]);
                }
            }
        }

        $data = [
            'name' => $first_name . ' ' . $last_name,
            'email' => $email,
            'contact' => $contact,
            'address' => $address,
            'date' => $date,
            'time' => $time,
            'msg' => $message,
            'artpiece' => $artpiece
        ];

        Mail::send('email.inquire', $data, function($message) use($data) {
            $message->to('info@artcavegallery.com')
            ->subject('INQUIRY - ' . date('M d, Y h:i A'))
            ->from('info@artcavegallery.com', $data['name']);
        });

        return response()->json(1);
    }

    public function sendMessage(Request $request) {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
            'msg' => $request->message,
        ];

        Mail::send('email.contact', $data, function($message) use($data) {
            $message->to('info@artcavegallery.com')
            ->subject('CONTACT US - ' . date('M d, Y h:i A'))
            ->from('info@artcavegallery.com', $data['name']);
        });

        return response()->json(1);
    }
}
