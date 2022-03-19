<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (!CheckOTPass(1,$request->otpass)) {
                Auth::logout();
                return redirect('login');
            } else {
            session()->flash('success', '欢迎回来！');
            // return redirect()->route('users.show', [Auth::user()]);
            // return redirect()->route('管理后台');
            // $fallback = route('users.show', Auth::user());
            // return redirect()->intended($fallback);
            if (Gate::allows('CheckAdmin')) {
                return redirect()->route('admin_edit');
            } else {
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            }
        }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;
    }

    public function __construct()
    {
        // $this->middleware('guest', [
        //     'only' => ['create']
        // ]);
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
