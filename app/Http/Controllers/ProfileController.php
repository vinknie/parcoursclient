<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $getCategory = Category::where('id_user', Auth::user()->id)->get();

        return view('profile.edit', [
            'user' => $request->user(), 'getCategory' => $getCategory
        ]);
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
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        // admin account cant be deleted
        if ($user['role'] === 'admin') {
            return redirect()->back()->with('status', 'user-not-deleted');
        };

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }

    // create user
    public function createUser()
    {
        $getCategory = Category::where('id_user', Auth::user()->id)->get();
        return view('admin.createUser', compact('getCategory'));
    }

    // store user
    public function storeUser(Request $request)
    {
        $validation = $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|max:255|unique:users'
        ]);

        $password = Str::random(8);

        $user = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($password);

        // sending mail to user email
        Mail::send('emails.user-created', ['user' => $user, 'password' => $password], function ($message) use ($user) {
            $message->to($user->email)->subject('Welcome to Our Website');
        });

        $user->save();

        return redirect()->back()->with('success', 'User created successfully.');
    }
}
