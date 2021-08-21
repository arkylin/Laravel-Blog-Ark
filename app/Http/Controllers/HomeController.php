<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home.index');
    }
    
    public function sitemap()
    {
        // return view('static_pages/sitemap')->header("Content-type","text/xml");
        return response(GetSitemap())->header('Content-Type', 'text/xml');
    }
}
