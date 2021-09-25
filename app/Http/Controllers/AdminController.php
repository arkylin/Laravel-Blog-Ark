<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Policies\UserPolicy;

class AdminController extends Controller {
    public function admin() {
        return view('admin/main');
    }

    public function edit(Request $action, User $user) {
        $this->authorize('CheckAdmin', $user);
        $GetRequest = $action->all();
        if (array_key_exists('id', $GetRequest) && !array_key_exists('content', $GetRequest)) {
            $post_get = Post::find($GetRequest['id']);
            return view('admin/edit', ['post' => $post_get]);
        } elseif ( array_key_exists('id', $GetRequest) && array_key_exists('content', $GetRequest) ) {
            Post::where('id', $GetRequest['id'])->update($GetRequest);
            return '提交成功！';
        } elseif ( !array_key_exists('id', $GetRequest) && array_key_exists('new', $GetRequest) && !array_key_exists('content', $GetRequest) ) {
            return view('admin/new');
        } elseif ( array_key_exists('new', $GetRequest) && array_key_exists('content', $GetRequest) ) {
            unset($GetRequest['new']);
            Post::insert($GetRequest);
            return '提交成功！';
        } else {
            $posts = Post::select('id')->orderBy('created','desc')->get()->toArray();
            if (array_key_exists('page', $GetRequest)) {
                return view('admin/lists', ['posts' => $posts, 'page' => (int)$GetRequest['page'], 'type' => 'admin']);
            }
            return view('admin/lists', ['posts' => $posts, 'page' => 1, 'type' => 'admin']);
        }
    }
    
    public function upload(User $user, Request $request){
        $this->authorize('CheckAdmin', $user);
    	if ($request->isMethod('POST')) { //判断是否是POST上传，应该不会有人用get吧，恩，不会的
    		//在源生的php代码中是使用$_FILE来查看上传文件的属性
    		//但是在laravel里面有更好的封装好的方法，就是下面这个
    		//显示的属性更多
    		$fileCharater = $request->file('photo');
            $FileUploadTime = time();
 
    		if ($fileCharater->isValid()) { //括号里面的是必须加的哦
    			//如果括号里面的不加上的话，下面的方法也无法调用的
 
                // 原文件名
                $originalName = $fileCharater->getClientOriginalName();
    			//获取文件的扩展名 
    			$ext = $fileCharater->getClientOriginalExtension();
                // $ext = 'png';
 
    			//获取文件的绝对路径
    			$path = $fileCharater->getRealPath();
 
    			//定义文件名 uniqid()
    			$filename = $FileUploadTime.'.'.$ext;
                $filepath = 'attachments/' . date("Y",$FileUploadTime) . '/' . date("m",$FileUploadTime) . '/' . $filename;
 
    			//存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
                if (env('ASSETS_URL') != '' && env('COSV5_SECRET_KEY') != '') {
                    Storage::disk('cosv5')->put($filepath, file_get_contents($path));
                    return env('ASSETS_URL') . '/' . $filepath;
                } else {
                    Storage::disk('static')->put($filepath, file_get_contents($path));
                    return env('APP_URL') . '/static/' . $filepath;
                }
                // Storage::disk('oss')->put($filepath, file_get_contents($path));
                // return env('ASSETS_URL') . '/' . $filepath;
    		}
    	}
    	// return view('upload');
    }

    public function config(Request $action, User $user) {
        $this->authorize('CheckAdmin', $user);
        $GetRequest = $action->all();
        $config = Config::get()->toArray();
        if (empty($GetRequest) || array_key_exists('new', $GetRequest)) {
            return view('admin/config',['config' => $config]);
        } else {
            foreach ($config as $conf) {
                Config::where('name', $conf['name'])->update(['value' => $GetRequest[$conf['name']]]);
            }
            redirect(url()->current() . '?new');
        }
    }
}
