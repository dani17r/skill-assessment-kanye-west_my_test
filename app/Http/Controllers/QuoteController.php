<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favorite;
use GuzzleHttp\Client;

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

  public function index(Request $request, Client $client)
  {

    $limit = intval($request->get('limit')) ?? 5;

    $user = Auth::user();
    $countFavorite = Favorite::where(['user_id' => $user->id])->count();
    $responses = [];

    for ($i = 0; $i < $limit; $i++) {
      $response = json_decode($client->request('GET')->getBody());
      $favorite = Favorite::where(['quote' => $response->quote, 'user_id' => $user->id])->first();

      if($favorite){
        $response->like = boolval($favorite->like);
        $response->dislike = boolval($favorite->dislike);
      }
      else {
        $response->like = false;
        $response->dislike = false;
      }
      
      $responses[] = $response;
    }

    return response()->json([ 
      'total_favorites' => $countFavorite,
      'data' => $responses, 
    ]);
  }
}
