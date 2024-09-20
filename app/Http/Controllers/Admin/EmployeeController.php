<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Pagination\Paginator;

class EmployeeController extends Controller
{
    public function index($language, Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('page', 1); // Get the current page, default to 1
        $editorCount = User::where('role', 'editor')->count();
        $contentCount = User::where('role', 'content')->count();
        $userCount = User::where('role', 'user')->count();

        echo ($currentPage);
        // Set the current page for the pagination
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        if ($perPage === 'all') {
            $employees = User::orderBy('posts.updated_at', 'desc')->all();
        } else {
            $employees = User::select('*')->orderBy('updated_at', 'desc')->paginate($perPage);
        }

        return view('pages.employee.employee', compact('employees', 'perPage', 'currentPage', 'editorCount', 'contentCount', 'userCount'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $query = User::query()
            ->where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->orderBy('updated_at', 'desc');

        $employees = $query->paginate(10);
        $editorCount = $query->get()->where('role', 'editor')->count();
        $contentCount = $query->get()->where('role', 'content')->count();
        $userCount = $query->get()->where('role', 'user')->count();
        $perPage = 10;
        $currentPage = 1;
        return view('pages.employee.employee', compact('employees', 'perPage', 'currentPage', 'editorCount', 'contentCount', 'userCount'));
    }
    public function edit($id)
    {
        $employee = User::find($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = User::find($id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->role = $request->role;
        $employee->save();

        return response()->json(['success' => 'Employee updated successfully']);
    }
    public function updatePassword(Request $request, $id)
    {
        $employee = User::find($id);
        $employee->password = bcrypt($request->password);
        $employee->save();

        return response()->json(['success' => 'Password updated successfully']);
    }

    public function delete($id)
    {
        $employee = User::find($id);

        if ($employee) {
            $employee->delete();
            return response()->json(['success' => 'Employee deleted successfully']);
        } else {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }

    public function save(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|max:255|email|unique:users',
            'role' => 'required|integer',
            'password' => 'nullable|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create a new User instance
        $employee = new User;
        $employee->name = $validatedData['name'];
        $employee->email = $validatedData['email'];
        $employee->role = $validatedData['role'];

        // Check if password is provided and hash it
        if (!empty($validatedData['password'])) {
            $employee->password = bcrypt($validatedData['password']);
        }

        // Check if an avatar file is uploaded
        if ($request->hasFile('avatar')) {
            $imageFile = $request->file('avatar');
            $imageName = $imageFile->getClientOriginalName();
            $request->avatar->move(public_path('images'), $imageName);
            $employee->avatar = $imageName; // Save the image name to the employee's avatar field
        }

        // Save the employee to the database
        $employee->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Employee saved successfully!');
    }

    //---------------------------------------------API----------------------------------------------//
    public function getEmployees(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Employee model
        $query = User::query();

        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('users.name', 'like', "%$search%")
                    ->orWhere('users.email', 'like', "%$search%");
            });
        }

        // Join with roles table
        $query->join('roles', 'users.role', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name');

        // Apply pagination or retrieve all
        if ($perPage == -1) {
            $employees = $query->orderBy('users.updated_at', 'desc')->get();
        } else {
            $employees = $query->orderBy('users.updated_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
        }

        return response()->json($employees);
    }

    public function getEmployee($id)
    {
        $employee = User::find($id);
        return response()->json($employee);
    }
    public function getEmployeeCount(Request $request)
    {
        $response = [];

        // Get total count of all users
        $totalCount = User::count();
        $response['totalCount'] = $totalCount;

        // Get counts for each role
        $roles = Roles::all(); // Assuming 'Role' is your model for roles
        foreach ($roles as $role) {
            $count = User::where('role', $role->id)->count();
            $response[$role->name] = $count; // Assuming 'name' is the attribute for role names
        }

        return response()->json($response); // Assuming you're returning JSON response
    }

    public function addEmployee(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|max:255|email',
            'role' => 'required|integer',
            'password' => 'nullable|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!empty($validatedData['email']) && User::where('email', $validatedData['email'])->exists()) {
            return response()->json(['success' => false, 'message' => 'Email already exists'], 400);
        }

        // Create a new User instance
        $employee = new User;
        $employee->name = $validatedData['name'];
        $employee->email = $validatedData['email'];
        $employee->role = $validatedData['role'];

        // Check if password is provided and hash it
        if (!empty($validatedData['password'])) {
            $employee->password = bcrypt($validatedData['password']);
        }

        // Check if an avatar file is uploaded
        if ($request->hasFile('avatar')) {
            $imageFile = $request->file('avatar');
            $imageName = $imageFile->getClientOriginalName();
            $request->avatar->move(public_path('images/profile'), $imageName);
            $employee->avatar = $imageName; // Save the image name to the employee's avatar field
        }

        // Save the employee to the database
        $employee->save();

        // Redirect back with a success message
        return response()->json(['success' => 'Employee added successfully']);
    }
    public function updateEmployee(Request $request)
    {
        $employee = User::find($request->id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->role = $request->role;
        $employee->save();

        return response()->json(['success' => 'Employee updated successfully']);
    }

    public function getEmployeeTotalPage(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $totalCount = User::count(); // You can use count() directly without fetching all records
        $totalPage = (int) ceil($totalCount / $perPage); // Use ceil to round up to the nearest whole number

        return response()->json(['total_page' => $totalPage]);
    }

    public function updateEmployeePassword(Request $request)
    {
        $employee = User::find($request->id);
        $employee->password = bcrypt($request->password);
        $employee->save();

        return response()->json(['success' => 'Password updated successfully']);
    }
    public function deleteEmployee(Request $request)
    {
        $employee = User::find($request->id);

        if ($employee) {
            $employee->delete();
            return response()->json(['success' => 'Employee deleted successfully']);
        } else {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }

    public function updateIsActive(Request $request)
    {
        $id = $request->input('id');
        $isActive = $request->input('isActive');

        // Update isActive in database for the specified post
        $user = User::find($id);
        if ($user) {
            $user->isActive = ($isActive === 'yes') ? 'yes' : 'no';
            $user->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'User not found']);
    }
    public function getEmployeesWithoutAdmin()
    {
        $adminRole = Roles::where('name', 'admin')->first();
        $roles = Roles::all();
        $employees = User::where('role', '!=', $adminRole->id)->get();

        return response()->json(['success' => true, 'data' => $employees, 'roles' => $roles]);
    }


}
