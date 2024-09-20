<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Display dashbnoard of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

    }

    public static function checkRole($email)
    {
        // Retrieve the user by email using Eloquent
        $user = User::where('email', $email)->first(); // Using first() to get a single user
        $role = Roles::where('id', $user->role)->first();
        if ($user && $role->name == 'user') {
            return 0; // User role is 'user', return 0
        } else if ($user && $role->name == 'content') {
            return 1; // User not found or role is not 'user', return 1
        } else if ($user && $role->name == 'editor') {
            return 2; // User not found or role is not 'user', return 1
        }
        return 3;
    }

    public function addRole(Request $request)
    {
        $name = $request->input('role');
        $role = new Roles();
        $role->name = $name;
        $role->save();
        return response()->json(['success' => true, 'message' => 'Role is added successfully']);
    }

    public function getRoles(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Employee model
        $query = Roles::query();
        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if ($perPage == -1) {
            $roles = $query->orderBy('id', 'asc')->all();
        } else
            $roles = $query->orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $currentPage);
        return response()->json($roles, 200);
    }

    public function getRole(Request $request)
    {
        $role = Roles::find($request->id);
        return response()->json($role, 200);
    }

    public function updateRole(Request $request)
    {
        $role = Roles::find($request->id);
        $role->name = $request->name;
        $role->save();

        return response()->json(['success' => 'Role updated successfully']);
    }

    public function getRoleTotalPage(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $totalCount = Roles::count(); // You can use count() directly without fetching all records
        $totalPage = (int) ceil($totalCount / $perPage); // Use ceil to round up to the nearest whole number

        return response()->json(['total_page' => $totalPage]);
    }
    public function deleteRole(Request $request)
    {
        $role = Roles::find($request->id);

        if ($role) {
            $role->delete();
            return response()->json(['success' => 'Role deleted successfully']);
        } else {
            return response()->json(['error' => 'Role not found'], 404);
        }
    }
}