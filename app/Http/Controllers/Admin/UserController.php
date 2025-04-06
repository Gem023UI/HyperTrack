<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Add this line

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function getUsers()
    {
        // Datatable implementation will go here
        return response()->json([]);
    }

    // Add other methods (create, store, edit, update, destroy) as needed
}