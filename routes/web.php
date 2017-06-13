<?php

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

use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('graph/login', function () {
    $clientId = env('GRAPH_KEY');
    $clientSecret = env('GRAPH_SECRET');
    $redirectUrl = env('GRAPH_REDIRECT_URI');
    $additionalProviderConfig = ['site' => 'o365.fcu.edu.tw'];
    $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);

    return Socialite::with('graph')->scopes(['email', 'profile', 'User.Read'])
        ->setConfig($config)->redirect();

});

Route::get('dump', function () {
    $user = Socialite::driver('graph')->user();
    $accessTokenResponseBody = $user->accessTokenResponseBody;
    dd(request()->all(), $user, $accessTokenResponseBody);
});
