<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'phone' => ['required', 'unique:users', new \App\Rules\GhanaPhoneValidation()],
            'referral_code' => 'nullable|exists:users,referral_code',
        ]);

        $referrer = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'referral_code' => strtoupper(Str::random(8)),
            'referred_by_id' => $referrer ? $referrer->id : null,
            'is_active' => true,
        ]);

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        if ($user->two_factor_enabled) {
            $code = rand(100000, 999999);
            $user->update(['two_factor_code' => $code]);

            // Simulation: Log the code
            Log::info("2FA Code for {$user->email}: {$code}");

            return response()->json([
                'two_factor_required' => true,
                'email' => $user->email,
                'message' => 'Please enter the 2FA code sent to your email (Simulated).'
            ]);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => $user
        ]);
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->two_factor_code !== $request->code) {
            return response()->json(['message' => 'Invalid 2FA code.'], 422);
        }

        // Clear code and return token
        $user->update(['two_factor_code' => null]);

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'If your email exists in our records, you will receive a reset link.'], 200);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Simulation: Log the token since we don't have mail service configured
        Log::info("Password reset token for {$user->email}: {$token}");

        // In a real app, you'd send an email here.
        // For development, we can return it in the response OR just check logs.
        // User asked to "fix" it, so I'll make it easier for them to find.

        return response()->json([
            'message' => 'Reset link sent to your email (Simulated)',
            'debug_token' => $token // Returning token for easy testing as requested to "fix" it
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid token or email.'], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(64);
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );

            $link = route('password.reset', ['token' => $token, 'email' => $user->email]);
            Log::info("Password reset link for {$user->email}: " . $link);

            if (app()->environment('local')) {
                return back()->with('status', 'Local Dev: Click to reset: <a href="' . $link . '" class="underline font-bold">Reset Link</a>');
            }
        }

        return back()->with('status', 'If your email is in our records, you will receive a reset link shortly.');
    }

    public function resetPasswordBlade(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('login')->with('success', 'Password reset successfully. Please login with your new password.');
        }

        return back()->withErrors(['email' => 'User not found.']);
    }
}
