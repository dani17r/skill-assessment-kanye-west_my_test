<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class QuoteController extends BaseController
{
  /**
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */

  public function __construct()
  {
    $this->middleware('throttle:30,1');
  }

  public function index(Request $request, Http $Http)
  {
    $user = Auth::user();
    $countFavorite = $user->favorites()->count();
    $limit = intval($request->get('limit'));

    $responses = collect(range(1, $limit))->map(function () use ($Http, $user) {
      $response = json_decode($Http::ApiKanye()->get('/'));
      $favorite = $user->favorites()->where('quote', $response->quote)->first();

      if ($favorite) {
        $response->like = $favorite->like;
        $response->dislike = $favorite->dislike;
      } else {
        $response->like = false;
        $response->dislike = false;
      }

      return $response;
    });
  
    return response()->json([ 
      'total_favorites' => $countFavorite,
      'data' => $responses, 
    ]);
  }
}
