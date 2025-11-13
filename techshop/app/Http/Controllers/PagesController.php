<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function returnPolicy()
    {
        return view('pages.return-policy');
    }

    public function howToBuy()
    {
        return view('pages.how-to-buy');
    }
}
