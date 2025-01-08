<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Get all users
    public function index()
    {
        return User::with('role')->get(); // Include role relationship
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']); // Hash password

        $user = User::create($validated);

        return response()->json($user, 201); // 201 = Created
    }

    // Show a single user
    public function show(User $user)
    {
        return $user->load('role'); // Include role relationship
    }

    // Update a user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|confirmed|min:6',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']); // Hash password if provided
        }

        $user->update($validated);

        return response()->json($user, 200); // 200 = OK
    }

    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204); // 204 = No Content
    }
}
