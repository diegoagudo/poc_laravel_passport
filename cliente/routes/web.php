<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/callback', function (\Illuminate\Http\Request $request) {

    $tokenUrl = sprintf("http://%s/oauth/token",
        ENV('PASSPORT_SERVER_HOST')
    );

    $response = \Illuminate\Support\Facades\Http::post($tokenUrl, [
       'grant_type' => 'authorization_code',
       'client_id' => ENV('PASSPORT_CLIENT_ID'),
       'client_secret' => ENV('PASSPORT_CLIENT_SECRET'),
       'redirect_url' => ENV('PASSPORT_REDIRECT_URI'),
       'code' => $request->code
    ]);

    dd($response->json());

});

Route::get('/', function () {
    $state = \Illuminate\Support\Str::random(256);

    $queryParams = http_build_query([
        'client_id' => ENV('PASSPORT_CLIENT_ID'),
        'redirect_url' => ENV('PASSPORT_CLIENT_SECRET'),
        'response_type' => 'code',
        'scope' => 'place-orders',
        'state' => $state,
    ]);

    $loginUrl = sprintf("http://%s/oauth/authorize?%s",
        ENV('PASSPORT_SERVER_HOST'), $queryParams
    );

    return view('welcome', [
        'loginUrl' => $loginUrl
    ]);
});
