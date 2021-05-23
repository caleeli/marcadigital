<?php

namespace App\Http\Controllers;

use App\Traits\OAuthProviders;

class HomeController extends Controller
{
    use OAuthProviders;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['load_js' => true, 'oauthProviders' => $this->oauthProviders(2)]);
    }
}
