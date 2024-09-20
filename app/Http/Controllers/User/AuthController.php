<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if ($user->email_verified !== 1)
                return response()->json(['error' => 'Email is not verified'], 401);
            if ($user->isActive === 'no')
                return response()->json(['error' => 'This account does not activated'], 401);
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->forceFill([
                'remember_token' => $token,
            ])->save();
            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['error' => 'Error logging in. Please check your email and password.'], 401);
    }

    public function signinWithToken(Request $request)
    {
        return response()->json($request->user());
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $password = Str::random(6);
        $user->password = bcrypt($password);
        $user->save();
        Mail::send('emails.forgotPassword', ['code' => $password], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verify Your Email Address');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        return response()->json(['message' => 'Password sent to your email.'], 201);
    }
    /**
     * make the user able to register
     *
     * @return 
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'referralCode' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'agreeToTerms' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload (avatar)

        if ($request->hasFile('avatar')) {
            $imageFile = $request->file('avatar');
            $avatarName = $imageFile->getClientOriginalName();
            $request->file('avatar')->move(public_path('images'), $avatarName);
        }

        $referralCode = $request->input('referralCode');
        $referred_by = null;
        if ($referralCode) {
            $user = User::where('referral_code', $referralCode)->first();
            if (!$user)
                return response()->json(['message' => 'Please input correct referral code.'], 404);
            $referred_by = $user->id;
        }

        do {
            $referralCode = Str::random(6);
        } while (User::where('referral_code', $referralCode)->exists());


        // Create user
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'referral_code' => $referralCode,
            'referred_by' => $referred_by,
            'password' => bcrypt($request->input('password')),
            'avatar' => $avatarName,
            'email_verification_code' => Str::random(6),
            'email_verified' => false,
        ]);
        Mail::send('emails.verify', ['code' => $user->email_verification_code], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verify Your Email Address');
            $message->from('xyz@gmail.com', 'TnreadersOffical');
        });

        $user->save();
        return response()->json(['message' => 'Verification code sent to your email.'], 201);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|string|max:6',
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('email_verification_code', $request->input('verification_code'))
            ->first();

        if (!$user) {
            $user->delete();
            return response()->json(['message' => 'Invalid verification code or email.'], 400);
        }

        $user->email_verified = true;
        $user->email_verification_code = null;
        $user->save();

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }
}