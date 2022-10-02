<?php

namespace App\Http\Controllers;

use App\Rules\PasswordIsTheSameInvokableRule;
use App\Rules\PasswordMatchesInvokableRule;
use App\Rules\UsernameCanBeChangedInvokableRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

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
    // Check if user is the one trying to update profile.
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $user = $request->user();
    }

    $validator = Validator::make($request->all(), [
      'first_name' => ['required', 'max:255'],
      'last_name' => ['required', 'max:255'],
      'avatar' => ['mimes:jpeg,png', 'max:255', 'max:2048'],
      'username' => ['required', 'max:255', Rule::unique('users', 'username')
        ->ignore(auth()->user()->id, 'id'), new UsernameCanBeChangedInvokableRule],
      'bio' => 'max:255',
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')
        ->ignore(auth()->user()->id, 'id')],
      'oldPassword' => ['nullable', 'max:255', new PasswordMatchesInvokableRule],
      'password' => [Rule::excludeIf($request->oldPassword == null), 'min:8', 'max:255',
        Rules\Password::defaults(), new PasswordIsTheSameInvokableRule],
      'password_confirmation' => [Rule::excludeIf($request->oldPassword == null), 'max:255', 'same:password',],
    ], [
      'required' => 'The :attribute field can not be blank!',
      'avatar' => 'Avatar is wrong format (must be jpeg/png) OR is larger than 2MB!',
    ]);

    if ($validator->passes()) {
      // Make sure user tries to change the password:
      // Old password field must be entered and pass the validator.
      // Otherwise, without this 'if' it would be re-hashed and changed every time.
      if ($request->input('oldPassword') != null) {
        $formFields = $request->except(['oldPassword', 'password_confirmation']);
        $formFields['password'] = Hash::make($request->password);
      } else {
        $formFields = $request->except(['oldPassword', 'password', 'password_confirmation']);
      }
      if ($request->hasFile('avatar')) {
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
      }
      $user->update($formFields);
      return back()->with('message', 'Profile has been updated!');
    } else {
      if ($validator->errors()->hasAny('oldPassword', 'password', 'password_confirmation')) {
        return back()->withErrors($validator)->with('checked', true);
      }
      return back()->withErrors($validator);
    }
  }
}
