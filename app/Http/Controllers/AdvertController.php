<?php

namespace App\Http\Controllers;

use App\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AdvertController
 * @package App\Http\Controllers
 *
 * @property $user
 */
class AdvertController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();

        if(!$this->user){
            redirect()->route('/');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adverts = Advert::where('user_id', '>', 0)
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        return ok([
            'status' => 'succesds',
            'data'   => [
                'adverts' => $adverts
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return forbidden();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Advert $advert
     * @return \Illuminate\Http\Response
     */
    public function show(Advert $advert)
    {
        return forbidden();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Advert $advert
     * @return \Illuminate\Http\Response
     */
    public function edit(Advert $advert)
    {
        return forbidden();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Advert $advert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advert $advert)
    {
        return forbidden();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Advert $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advert $advert)
    {
        $advert->delete();

        return ok();
    }
}
