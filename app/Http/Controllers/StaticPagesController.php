<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class StaticPagesController extends Controller
{
    //
    public function home()
    {
        // $posts = Post::orderBy('created','desc')->limit(20)->get();
        if (Gate::allows('CheckAdmin')) {
            $posts = Post::select('id')->orderBy('created','desc')->get()->toArray();
            // $posts = Post::orderBy('created','desc')->paginate()->toArray();
        } else {
            $posts = Post::select('id')->where('status','publish')->orderBy('created','desc')->get()->toArray();
            // $posts = Post::where('status','publish')->orderBy('created','desc')->get()->toArray();
        }
        // $posts = Post::orderBy('created','desc')->get('id');
        // return $posts;
        return view('static_pages/home', ['posts' => $posts,'page' => 1]);
    }

    public function page($page)
    {
        if (Gate::allows('CheckAdmin')) {
            $posts = Post::select('id')->orderBy('created','desc')->get()->toArray();
        } else {
            $posts = Post::select('id')->where('status','publish')->orderBy('created','desc')->get()->toArray();
        }
        // $posts = Post::orderBy('created','desc')->get('id');
        // return $posts;
        return view('static_pages/home', ['posts' => $posts, 'page' => $page]);
    }
}
