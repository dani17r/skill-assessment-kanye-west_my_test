<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_banning', [
            'only' => ['view', 'destroy', 'updateOrCreate', 'getAll'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        return Inertia::render('Favorite');
    }

    public function getAll(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit');
        $favorites = Favorite::where(['user_id' => $user->id,])->orderByDesc('id')->paginate(intval($limit));
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
    public function destroy(Favorite $favorite, Request $request)
    {
        $user = Auth::user();
        $request->validate(["quote" => 'required|string']);
        
        $favorite = Favorite::where([
            'quote' => $request->quote,
            'user_id' => $user->id,
        ])->delete();

        return response()->json($favorite);
    }
}
