<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * assign roles with custom permission logic
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1); // Md. Shakil Ahsan (Super Admin) check

            if ($isSuper) {
                return $next($request);
            }

            // চ্যাট দেখার পারমিশন চেক
            if (!$u->hasPermission('view_chat')) {
                abort(403, 'আপনার চ্যাট এক্সেস করার অনুমতি নেই।');
            }

            return $next($request);
        });
    }

    /**
     * Display chat index
     * * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('id','!=',auth()->guard('admin')->user()['id'])->get();

        return view('admin.chat.index',compact('users'));
    }
}