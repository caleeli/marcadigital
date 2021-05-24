<?php

namespace App\Http\Controllers;

use App\Certification;

class CredentialController extends Controller
{
    public function show(Certification $credential)
    {
        return view('credential', compact('credential'));
    }
}
