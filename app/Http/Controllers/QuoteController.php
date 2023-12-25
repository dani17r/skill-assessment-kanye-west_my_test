<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
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

  public function index(Client $client)
  {
    $responses = [];

    for ($i = 0; $i < 5; $i++) {
      $response = $client->request('GET');
      $responses[] = json_decode($response->getBody());
    }

    return response()->json($responses);
  }
}
