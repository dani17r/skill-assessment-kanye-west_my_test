<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;


class ProfileController extends BaseController
{

  public function __construct()
  {
    $this->middleware('is_admin', [
      'only' => ['view_all', 'update_by_admin', 'getAll']
    ]);
  }

  /**
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */

  public function view()
  {
    return Inertia::render('Profile');
  }

  public function view_all()
  {
    return Inertia::render('Users');
  }

  public function getAll(Request $request)
  {
    $limit = $request->get('limit');
    $favorites = User::where('id', '!=', Auth::id())
    ->orderBy('created_at')
    ->paginate(intval($limit));

    return response()->json($favorites);
  }

  public function update_by_admin(Request $request)
  {
    $request->validate([
      'user_id' => 'required',
      'moderating' => 'numeric',
      'banning' => 'boolean',
    ]);
    
    $update = User::where(['id' => $request->user_id])->update([
      'moderating' =>  $request->moderating,
      'banning' =>  $request->banning,
    ]);

    return response()->json($update);
  }

  public function show()
  { 
    $user = Auth::user()->makeVisible('isAdmin');
    $user->isAdmin = boolval($user->isAdmin);
    return response()->json([ 'user' => $user ]);
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
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
