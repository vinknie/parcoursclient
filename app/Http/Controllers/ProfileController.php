<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// email
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Exception;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $getCategory = Category::all();

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
        $getCategory = Category::all();
        return view('admin.createUser', compact('getCategory'));
    }

   // store user
   public function storeUser(Request $request)
   {
       $validation = $request->validate([
           'name'      => 'required|max:255',
           'email'     => 'required|max:255|unique:users|email'
       ]);

       $password = Str::random(8);

       $user = new User;

       $user->name     = $request->name;
       $user->email    = $request->email;
       $user->password = Hash::make($password);


       // sending mail to user email
       $data = [
        'subject' => 'Compte créé - EvalNum',
        'title' => 'Bonjour ' . $user->name,
        'body' => "Votre compte a été créé sur notre site web prij.parcoursnum.fr. Voici vos informations de connexion :
            Email : " . $user->email . "
            Mot de passe : " . $password .  "
            Nous espérons que vous apprécierez l'utilisation de notre site web !",
    ];

       try {
           Mail::to($user->email)->send(new MailNotify($data));
           $user->save();
           return redirect()->back()->with('success', 'User created successfully.');
       } catch (Exception $e) {
           throw $e;
           return redirect()->back()->with('error', 'Could not create user.');
       }

       /***
        * developement mail sending
        */
       // Mail::send('emails.user-created', ['user' => $user, 'password' => $password], function ($message) use ($user) {
       //     $message->to($user->email)->subject('Welcome to Our Website');
       // });

       

   }


    // get all users (admin)
    public function getUsers()
    {
        $getCategory = Category::all();
        $users = User::where('role', '!=', 'admin')->paginate(10);

        $trashedUsers = User::onlyTrashed()->latest()->paginate(5);
        return view('admin.users.all-users', compact('getCategory', 'users', 'trashedUsers'));
    }

    // edit user (admin)
    public function editUser($id)
    {
        $getCategory = Category::all();
        $user = User::find($id);
        return view('admin.users.edit-user', compact('getCategory', 'user'));
    }

    // update user (admin)
    public function updateUser(Request $request, $id)
    {
        $validation = $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|max:255|email'
        ]);

        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('no-user', 'No user found');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->updated_at = Carbon::now();
        $user->save();

        return redirect()->back()->with('success', 'User updated');
    }

    // delete user(admin)
    public function deleteUser($id)
    {
        $user = User::find($id)->delete();
        return redirect()->back()->with('success', 'User moved to trash');
    }

    // restore user(admin)
    public function restoreUser($id)
    {
        $restoreUser = User::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'User restored');
    }
}
