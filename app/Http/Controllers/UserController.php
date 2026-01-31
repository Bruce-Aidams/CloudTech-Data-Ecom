<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate($request->input('per_page', 10));

        // If this is an admin route, return the view
        if ($request->is('admin/*')) {
            return view('admin.users.index', compact('users'));
        }

        // Otherwise return JSON for API
        return $users;
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => ['required', 'string', 'unique:users', new \App\Rules\GhanaPhoneValidation()],
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin,agent,dealer,super_agent',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->boolean('is_active'),
            'referral_code' => strtoupper(Str::random(8)),
            'wallet_balance' => 0,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', Rule::unique('users')->ignore($user->id), new \App\Rules\GhanaPhoneValidation()],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:user,admin,agent,dealer,super_agent',
            'is_active' => 'boolean',
            'wallet_balance' => 'sometimes|numeric|min:0',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->has('wallet_balance')) {
            $data['wallet_balance'] = $request->wallet_balance;
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.users')->with('success', 'Password reset successfully');
    }

    /**
     * Toggle 2FA for the authenticated user
     */
    public function toggle2FA(Request $request)
    {
        $user = $request->user();
        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->save();

        return response()->json([
            'message' => 'Two-factor authentication ' . ($user->two_factor_enabled ? 'enabled' : 'disabled') . ' successfully',
            'two_factor_enabled' => $user->two_factor_enabled
        ]);
    }

    /**
     * Toggle user active status (activate/suspend)
     */
    public function toggleStatus(User $user)
    {
        try {
            // Log the attempt
            \Illuminate\Support\Facades\Log::info("Admin toggling status for user: {$user->id} ({$user->email}). Current status: {$user->is_active}");

            $user->is_active = !$user->is_active;
            $user->save();

            $status = $user->is_active ? 'activated' : 'suspended';

            \Illuminate\Support\Facades\Log::info("User {$user->id} status updated to: {$user->is_active}");

            return redirect()->back()->with('success', "User {$status} successfully");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error toggling status for user {$user->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update user status.');
        }
    }
}
