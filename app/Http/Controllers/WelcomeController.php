<?php

namespace App\Http\Controllers;

use App\Traits\OAuthProviders;

class WelcomeController extends Controller
{
    use OAuthProviders;

    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome', ['oauthProviders' => $this->oauthProviders(2)]);
    }
}
