<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function terms()
    {
        return view('pages.public.terms');
    }

}
