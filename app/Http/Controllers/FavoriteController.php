<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyCsrfToken::class]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Favorite');
    }

    public function getMany()
    {
        $favorites = Favorite::latest()->paginate(5);
        return response()->json($favorites);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateOrCreate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "like" => 'boolean',
            "dislike" => 'boolean',
            "quote" => 'required|string',
        ]);

        $favorite = Favorite::updateOrCreate(
            [
                'user_id' => $user->id, 
                'quote' => $request->quote
            ], 
            [
                'like' => $request->like,
                'dislike' => $request->dislike,
                "quote" => $request->quote,
                'user_id' => $user->id,
            ]
        );

        return response()->json($favorite);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
