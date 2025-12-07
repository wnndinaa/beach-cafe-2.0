<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function viewListofUsers(Request $request): View
{
    // Start query excluding the logged-in user
    $query = User::where('id', '!=', Auth::id());

    // Filter by role if provided
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Search by name or email if provided
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    // Fetch the filtered users
    $users = $query->get();

    return view('profile.index', ['users' => $users]);
}

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // delete users data
    public function deleteUser($id): RedirectResponse
{
    $user = User::findOrFail($id);

    try {
        $user->delete();
        return redirect()->route('profile.index')->with('success', 'User deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('profile.index')->with('error', 'Failed to delete user.');
    }
}


    public function editRole($id): View
{
    $user = User::findOrFail($id);
    return view('profile.edit-role', ['user' => $user]);
}

public function updateRole(Request $request, $id): RedirectResponse
{
    $request->validate([
        'role' => 'required|in:staff,customer',
    ]);

    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    return redirect()->route('profile.index')->with('success', 'User role updated successfully.');
}
}
