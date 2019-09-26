<?php

namespace App\Http\Controllers;

use App\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\stringFunction;

/**
 * Class AdvertController
 * @package App\Http\Controllers
 *
 * @property $user
 */
class AdvertController extends Controller
{

    use stringFunction;

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 10;

        if ($request->has('limit')) {
            $limit = (int)$request->input('limit');
        }

        $adverts = Advert::where('user_id', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        foreach ($adverts as $advert_id => $advert) {
            $adverts[$advert_id]['user'] = $advert->user;
            $adverts[$advert_id]['description'] = $this->limitText($advert->description, 255);
        }

        return ok([
            'status' => 'success',
            'data'   => [
                'adverts' => $adverts
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return bad_request([
                'status'  => 'error',
                'message' => 'validation error',
                'errors'  => $validator->errors()
            ]);
        }

        $user = Auth::user();

        if ($user) {

            Advert::create([
                'user_id'     => $user->id,
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            return ok([
                'status' => 'success',
            ]);
        }

        return bad_request([
            'status'  => 'error',
            'message' => 'Auth error',
            'errors'  => ['cant find user']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        $advert = Advert::find($id);

        if ($user && $advert && (int)$user->id === (int)$advert->user_id) {

            return ok([
                'status' => 'success',
                'data' => [
                    'advert' => $advert
                ]
            ]);
        }

        return bad_request([
            'status'  => 'error',
            'message' => 'Got error',
            'errors'  => ['cant find user or adert']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return bad_request([
                'status'  => 'error',
                'message' => 'validation error',
                'errors'  => $validator->errors()
            ]);
        }

        $id = (int)$request->input('id');

        $advert = Advert::find($id);

        $user = Auth::user();

        if ($user && $advert && (int)$user->id === (int)$advert->user_id) {

            $advert->title       = $request->input('title');
            $advert->description = $request->input('description');

            $advert->save();

            return ok([
                'status' => 'success',
            ]);
        }

        return bad_request([
            'status'  => 'error',
            'message' => 'Got error',
            'errors'  => ['cant find user or advert']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Advert $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = (int)$request->input('id');

        if(!$id){
            return bad_request([
                'status'  => 'error',
                'message' => 'not send advert id',
                'errors'  => ['not send advert id']
            ]);
        }

        $user = Auth::user();

        $advert = Advert::find($id);

        if ($user && $advert && (int)$user->id === (int)$advert->user_id) {

            $advert->delete();

            return ok([
                'status' => 'success',
            ]);
        }

        return bad_request([
            'status'  => 'error',
            'message' => 'Got error',
            'errors'  => ['cant find user or adert']
        ]);
    }
}
