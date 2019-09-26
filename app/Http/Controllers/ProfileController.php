<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 *
 * @property $user
 */
class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email',
            'phone'            => 'required',
            'password'         => 'required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'required_with:password|same:password',
        ]);

        $user = Auth::user();

        if ($user) {

            if ($request->hasFile('image')) {

                $image = $request->file('image')->store('public/users');

                if($image){
                    $user->image = Storage::url($image);
                }
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if($request->password){
                $user->password = bcrypt($request->password);
            }

            $user->save();
        }

        return redirect()->route('profile.index');
    }

    public function image()
    {
        $user = Auth::user();

        if($user && $user->image){

            unlink(public_path($user->image));

            $user->image = '';

            $user->save();

            return ok();
        }

        return bad_request();
    }
}
