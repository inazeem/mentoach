<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Add your dashboard logic here
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }
} 