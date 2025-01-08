<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Get all roles
    public function index()
    {
        return Role::all();
    }

    // Store a new role
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
        ]);

        $role = Role::create($validated);

        return response()->json($role, 201); // 201 = Created
    }

    // Show a single role
    public function show(Role $role)
    {
        return $role;
    }

    // Update a role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update($validated);

        return response()->json($role, 200); // 200 = OK
    }

    // Delete a role
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, 204); // 204 = No Content
    }
}
