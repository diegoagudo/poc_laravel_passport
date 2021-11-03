<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\TokenRepository;
use Psr\Http\Message\ServerRequestInterface;

class PassportLogoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout(Illuminate\Http\Request $request)
    {
        $oauthClients = DB::table('oauth_clients')
        ->where('id', $request->client_id)
        ->where('revoked', 0)
        ->first();

        if(!$oauthClients)
            die('Bad request');

        if(!$request->redirect_logout OR $request->redirect_logout != $oauthClients->redirect_logout)
            die('Bad request');
    }
}
