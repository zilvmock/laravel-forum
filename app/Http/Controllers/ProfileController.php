<?php

namespace App\Http\Controllers;

use App\Rules\PasswordAreTheSameInvokableRule;
use App\Rules\PasswordMatchesInvokableRule;
use App\Rules\UsernameCanBeChangedInvokableRule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
  // Views
  // **********************
  public function showProfileView()
  {

    return view('dashboard/profile', [
    ]);
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
    } else {
      $user = $request->user();
    }

    $fields = [
      'first_name' => strip_tags(clean($request->first_name)),
      'last_name' => strip_tags(clean($request->last_name)),
      'avatar' => $request->avatar,
      'username' => strip_tags(clean($request->username)),
      'bio' => $request->bio,
      'email' => strip_tags(clean($request->email)),
      'oldPassword' => strip_tags(clean($request->oldPassword)),
      'password' => strip_tags(clean($request->password)),
      'password_confirmation' => strip_tags(clean($request->password_confirmation)),
    ];

    if ($request->hasFile('avatar')) {
      $avatarValidator = Validator::make($fields, [
        'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
      ]);
      if ($avatarValidator->fails()) {
        return back()->withErrors($avatarValidator);
      }
    }

    $validator = Validator::make($fields, [
      'first_name' => ['required', 'max:255'],
      'last_name' => ['required', 'max:255'],
      'username' => ['required', 'max:255', Rule::unique('users', 'username')
        ->ignore(auth()->user()->id, 'id'), new UsernameCanBeChangedInvokableRule],
      'bio' => 'max:600',
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')
        ->ignore(auth()->user()->id, 'id')],
      'oldPassword' => ['nullable', 'max:255', new PasswordMatchesInvokableRule],
      'password' => [Rule::excludeIf($request->oldPassword == null), 'min:8', 'max:255',
        Rules\Password::defaults(), new PasswordAreTheSameInvokableRule],
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
        $fields = Arr::except($fields, ['oldPassword', 'password_confirmation']);
        $formFields['password'] = Hash::make($request->password);
      } else {
        $fields = Arr::except($fields, ['oldPassword', 'password', 'password_confirmation']);
      }
      if ($request->hasFile('avatar')) {
        $fields['avatar'] = $request->file('avatar')->store('avatars', 'public');;
      } else {
        $fields['avatar'] = $user->avatar;
      }
      $user->update($fields);
      return back()->with('message', 'Profile has been updated!');
    } else {
      if ($validator->errors()->hasAny('oldPassword', 'password', 'password_confirmation')) {
        return back()->withErrors($validator)->with('checked', true);
      }
      return back()->withErrors($validator);
    }
  }
}
