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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/logout2', [\App\Http\Controllers\Auth\PassportLogoutController::class,'logout']);


Route::middleware(['auth:api'])->get('/user', function (\Illuminate\Http\Request $request) {
    $token = \Illuminate\Support\Facades\Auth::user()->token();
    $tokenDecoded = json_decode($token, true);


    /**
     * Revoke token atual
     */
    $token->revoke();

    /**
     * Revoke token de todos os acessos do usuário
     * -- util para reset pass
     */
    /*
    DB::table('oauth_access_tokens')
        ->where('user_id', Auth::user()->id)
        ->update([
            'revoked' => true
        ]);
    */

    /**
     * logout do autorizador
     */

    DB::table('sessions')
        ->where('user_id', Auth::user()->id)
        ->update([
            'user_id' => null
        ]);
});
