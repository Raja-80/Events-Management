<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Display a list of users (Admin only)
    public function index()
    {
        $this->authorize('viewAny', User::class);  // Only allow admin users to view users

        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Display the form to create a new user (Admin only)
    public function create()
    {
        return view('users.create');
    }

    // Creat new user (Admin only)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',  // Default role
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show user details (Admin only)
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
