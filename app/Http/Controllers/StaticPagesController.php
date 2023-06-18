<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//10.5节 要添加以下两行的
use App\Models\Mblog;
use Illuminate\Support\Facades\Auth;


class StaticPagesController extends Controller
{
    public function home()
    {
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(10);
        }

        return view('static_pages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
