<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProfileController extends BaseController
{
  /**
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */

  public function __construct()
  {
    $this->middleware([Authenticate::class, VerifyCsrfToken::class]);
  }

  public function index()
  {
    return Inertia::render('Profile');
  }

  public function show()
  {
    return response()->json([ 'user' => Auth::user() ]);
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'image' => 'image|mimes:jpeg,png,jpg|max:2048',
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
    ]);

    if($request->hasFile('image')) {

      if (Storage::disk('public')->exists($user->image)) {
        Storage::disk('public')->delete($user->image);
      } 

      $image = $request->file('image');
      $imageName = time() . '.' . $image->extension();
      $path = $image->storeAs('images/profile', $imageName, 'public');
      
      $user->forceFill([
        'name' => $request->name,
        'email' => $request->email,
        'image' => $path
      ])->save();
    }
    else {
      $user->forceFill([
        'name' => $request->name,
        'email' => $request->email,
      ])->save();
    }

    return response()->json(['user' => $user]);
  }

  public function changePassword(Request $request)
  {
    $request->validate([
      'current_password' => ['required'],
      'new_password' => ['required', 'different:current_password', Rules\Password::defaults()],
      'check_new_password' => ['required','same:new_password'],
    ]);

    if (Hash::check($request->current_password, Auth::user()->password)) {
      Auth::user()->update(['password' => Hash::make($request->new_password)]);

      return response()->json(['success' => 'Password changed successfully!']);
    } else {
      throw new HttpResponseException(response()->json([
        'errors' => ['current_password' => ['Current password is incorrect']],
        'message' => 'Current password is incorrect'
      ], 422));
    }
  }
}
