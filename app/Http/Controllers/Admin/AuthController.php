<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Models\Roles;
use App\Models\DeviceToken;
use App\Http\Controllers\Admin\RoleController;

class AuthController extends Controller
{
    /**
     * Display login of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        $title = "Login";
        $description = "Some description for the page";
        return view('auth.login', compact('title', 'description'));
    }

    /**
     * Display register of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        $title = "Register";
        $description = "Some description for the page";
        return view('auth.register', compact('title', 'description'));
    }

    /**
     * Display forget password of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function forgetPassword()
    {
        $title = "Forget Password";
        $description = "Some description for the page";
        return view('auth.forget_password', compact('title', 'description'));
    }

    /**
     * make the user able to register
     *
     * @return 
     */
    public function signup(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        if ($validators->fails()) {
            return redirect()->route('register')->withErrors($validators)->withInput();
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            auth()->login($user);
            return redirect()->intended(route('dashboard.demo_one', 'en'))->with('message', 'Registration was successfull !');
        }
    }

    /**
     * make the user able to login
     *
     * @return 
     */
    public function authenticate(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validators->fails()) {
            return response()->json(['message' => 'Login failed! Email/Password is incorrect!'], 422);
        } else {
            if (RoleController::checkRole($request->email)) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $user = Auth::user();
                    if ($user->email_verified !== 1)
                        return response()->json(['message' => 'Email is not verified'], 401);
                    if ($user->isActive === 'no')
                        return response()->json(['message' => 'This account does not activated'], 401);
                    $token = $user->createToken('auth_token')->plainTextToken;
                    $user->role_name = Roles::find($user->role)->name;
                    return response()->json([
                        'status' => 'success',
                        'user' => $user,
                        'authorisation' => [
                            'token' => $token,
                            'type' => 'bearer',
                        ]
                    ]);
                } else {
                    // return redirect()->route('login')->with('message','Login failed !Email/Password is incorrect !');
                    return response()->json(['message' => 'Login failed! Email/Password is incorrect!'], 422);
                }
            } else
                return response()->json(['message' => 'Login failed! No Permission!'], 422);
        }
    }
    public function updateDeviceToken(Request $request)
    {
        $deviceToken = $request->input('device_token');
        $id = $request->input('id');
        $user = User::find($id);
        // Save or update the device token for the authenticated user
        $this->saveOrUpdateDeviceToken($user->id, $deviceToken);

        // Return the response with user and device token
        return response()->json([
            'user' => $user,
            'device_token' => $deviceToken,
        ]);
    }

    private function saveOrUpdateDeviceToken($userId, $deviceToken)
    {
        // Find existing token for the user
        $existingToken = DeviceToken::where('user_id', $userId)->first();

        if (!$existingToken) {
            // If no existing token, create a new one
            $existingToken = new DeviceToken();
            $existingToken->user_id = $userId;
        }

        // Update the token
        $existingToken->token = $deviceToken;
        $existingToken->save();
    }

    /**
     * make the user able to logout
     *
     * @return 
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Successfully Logged out !');
    }
    public function signout()
    {
        Auth::logout();
        return response()->json('Logged out successfully!');
    }

    public function changePassword(Request $request)
    {
        $password = $request->input('password');
        $id = $request->input('id');
        $user = User::find($id);
        $user->password = bcrypt($password);
        $user->save();
        return response()->json(['message' => 'Change password successfully!']);
    }

    public function updateProfile(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        $user->name = $request->input('name');
        if ($request->hasFile('img')) {
            $imageFile = $request->file('img');
            $imageName = $imageFile->getClientOriginalName();
            $request->img->move(public_path('images/profile'), $imageName);
            $user->avatar = $imageName;
        }
        $user->save();
        return response()->json(['message' => 'Profile updated successfully!']);

    }
    public function getRoleList(Request $request)
    {
        $roles = Roles::all();
        // Return JSON response
        return response()->json($roles);
    }
}