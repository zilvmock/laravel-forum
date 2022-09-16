<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Return dashboard views
    // **********************
    public function showProfileView()
    {
        return view('dashboard/profile');
    }

    public function showEditProfileView()
    {
        return view('dashboard/edit-profile');
    }
    // **********************

    public function updateProfile(Request $request)
    {
        if ($request->user()->id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $formFields = $request->validate([
            'first_name'=>'required | max:255',
            'last_name'=>'required | max:255',
            'username'=>['required', Rule::unique('users', 'username')->ignore(auth()->user()->id, 'id')],
            'email'=>['required', 'email', Rule::unique('users', 'email')->ignore(auth()->user()->id, 'id')],
            'bio'=>'max:255',
        ]);

        if(Hash::check($request->input('oldPassword'), auth()->user()->password)) {
            $request->validate([
                'password'=>['confirmed', 'min:3', 'max:255'],
            ]);
            $formFields['password'] = Hash::make($request->newPassword);
        }

        if($request->input('username') != auth()->user()->username) {
            if (auth()->user()->username_changed_at == null ||
                (auth()->user()->username_changed_at)->addDays(7) <= Carbon::now()) {
                $formFields['username_changed_at'] = Carbon::now()->toDateTimeString();
            } else {
                $formFields['username'] = auth()->user()->username;
            }
        }

        if($request->hasFile('avatar')) {
            if($request->file('avatar')->getSize() / 1024 ** 2 <= 2) {
                $formFields['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
        }

        auth()->user()->update($formFields);

        return back()->with('message', 'Profile has been updated!');
    }
}
