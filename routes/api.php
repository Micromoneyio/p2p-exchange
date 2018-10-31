<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# Auth routes
Route::post('register', 'AuthController@register');
Route::post('login',    'AuthController@login');
Route::post('recover',  'AuthController@recover');

# OAuth routes
Route::post('login/google',array('as'=>'glogin','uses'=>'AuthController@googleLogin')) ;
Route::post('login/facebook', 'AuthController@facebookLogin');

Route::group(['middleware' => ['jwt.auth']], function ($router) {
    # Auth routes
    Route::get('logout', 'AuthController@logout');

    # Resources routes
    Route::resource('assets',              'AssetController');
    Route::resource('asset_types',         'AssetTypeController');
    Route::resource('banks',               'BankController');
    Route::resource('currencies',          'CurrencyController');
    Route::resource('deals',               'DealController');
    Route::resource('deal_histories',      'DealHistoryController');
    Route::resource('deal_stages',         'DealStageController');
    Route::resource('favorite_currencies', 'FavoriteCurrencyController');
    Route::resource('market_histories',    'MarketHistoryController');
    Route::resource('notifications',       'NotificationController');
    Route::resource('orders',              'OrderController');
    Route::resource('rate_sources',        'RateSourceController');
    Route::resource('callbacks',           'CallbackController');
    Route::put('settings',            'SettingsController@update');

    Route::post('orders/filter','OrderController@filter');
    Route::post('deals/{deal}/pay', 'DealController@pay');
    Route::post('deals/{deal}/release', 'DealController@release');
    Route::post('deals/{deal}/cancel', 'DealController@cancel');
    Route::post('deals/{deal}/arbitrage_release', 'DealController@arbitrageReleaseEscrow');


    Route::post('connect/facebook', 'AuthController@connectFacebook');
    Route::post('connect/google', 'AuthController@connectGoogle');

    Route::post('disconnect/facebook', 'AuthController@disconnectFacebook');
    Route::post('disconnect/google', 'AuthController@disconnectGoogle');
});

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('password/reset/{token}', 'AuthController@showResetForm')->name('password.request');
Route::post('password/reset', 'AuthController@resetPassword')->name('password.reset');



Route::get('tst', function () {
    return App\Notification::create([
        'user_id' => 11,
        'deal_id' => 162,
        'text'    => 'asd',
        'viewed'  => 0
    ]);
});

Route::get('users/{user_id}', 'UsersController@public');

# Sync routes for BPM
Route::prefix('sync')->group(function () {
    Route::post('bank',           'SyncController@bank');
    Route::post('asset_type',     'SyncController@asset_type');
    Route::post('deal_stage',     'SyncController@deal_stage');
    Route::post('rate_source',    'SyncController@rate_source');
    Route::post('asset',          'SyncController@asset');
    Route::post('currency',       'SyncController@currency');
    Route::post('contact',        'SyncController@contact');
    Route::post('order',          'SyncController@order');
    Route::post('deal',           'SyncController@deal');
    Route::post('market_history', 'SyncController@market_history');
    Route::post('setting',        'SyncController@setting');
});
