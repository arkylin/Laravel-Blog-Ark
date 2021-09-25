<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function show($post)
    {
        $way = Route::currentRouteName();
        // $CheckAdmin = Gate::allows('CheckAdmin');
        if ($way == "post_slug") {
            $post = Post::where('slug', $post)->get();
            if (count($post) != 0) {
                $PostMetaData = GetPostMetaData($post[0]);
                if ($PostMetaData != "") {
                    return view('posts.show', ['post' => $PostMetaData]);
                } else {
                    return redirect() -> route('home');
                }
            } else {
                return redirect() -> route('home');
            }
        } elseif ($way == "post_api") {
            $post = Post::where('id', $post)->get();
            $PostMetaData = GetPostMetaData($post[0]);
            Post::where('id', $post)->update(['views' => (int)$post['views'] + 1]);
            if (count($post) != 0) {
                if ($PostMetaData != "") {
                    return view('posts.showapi', ['post' => $PostMetaData]);
                } else {
                    return redirect() -> route('home');
                }
            } else {
                return redirect() -> route('home');
            }
        }
    }
    public function search(Request $action) {
        $GetRequest = $action->all();
        if (array_key_exists('keyword',$GetRequest)) {
            $keyword = '%'.$GetRequest['keyword'].'%';
            $posts = Post::select('id')->where('title','like',$keyword)->orWhere('content','like',$keyword)->get()->toArray();
            return view('posts/list',[
                'posts'  => $posts
            ]);
        }
    }
    public function list($type, Request $action)
    {
        $GetRequest = $action->all();
        if (array_key_exists('page', $GetRequest)) {
            $page = (int)$GetRequest['page'];
        } else {
            $page = 1;
        }
        if ($type == 'search') {
            if (array_key_exists('keyword',$GetRequest)) {
                $keyword = '%'.$GetRequest['keyword'].'%';
                $posts = Post::select('id')->where('title','like',$keyword)->orWhere('content','like',$keyword)->get()->toArray();
                return view('posts/list',[
                    'posts'  => $posts,
                    'page' => $page,
                    'type' => $type,
                    'keyword' => $keyword
                ]);
            }
        }
        // $posts = Post::orderBy('created','desc')->limit(20)->get();
        if (Gate::allows('CheckAdmin')) {
            $posts = Post::select('id')->where('type', $type)->orderBy('created','desc')->get()->toArray();
            // $posts = Post::orderBy('created','desc')->paginate()->toArray();
        } else {
            $posts = Post::select('id')->where('type', $type)->where('status','publish')->orderBy('created','desc')->get()->toArray();
            // $posts = Post::where('status','publish')->orderBy('created','desc')->get()->toArray();
        }
        // $posts = Post::orderBy('created','desc')->get('id');
        // return $posts;
        return view('posts/list', [
            'posts' => $posts,
            'page' => $page,
            'type' => $type
        ]);
    }
}
