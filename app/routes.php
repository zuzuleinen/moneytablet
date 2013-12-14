<?php

/**
 * Application routes
 */
Route::get('/', array('before' => 'guest', 'uses' => 'HomeController@index'));

Route::get('account', array('before' => 'guest', 'uses' => 'AccountController@index'));
Route::get('account/login', array('before' => 'guest', 'uses' => 'AccountController@login'));
Route::post('account/loginPost', array('before' => 'guest', 'uses' => 'AccountController@loginPost'));
Route::get('account/create', array('before' => 'guest', 'uses' => 'AccountController@create'));
Route::post('account/createPost', array('before' => 'guest', 'uses' => 'AccountController@createPost'));
Route::get('account/success', array('before' => 'guest', 'uses' => 'AccountController@success'));
Route::get('account/logOut', 'AccountController@logOut');

Route::get('dashboard', array('before' => 'auth', 'uses' => 'DashboardController@index'));

Route::get('tablet/create', array('before' => 'auth', 'uses' => 'TabletController@create'));
Route::post('tablet/createPost', array('before' => 'auth', 'uses' => 'TabletController@createPost'));
Route::post('tablet/close', array('before' => 'auth', 'uses' => 'TabletController@close'));
Route::get('tablet/closeSuccess', array('before' => 'auth', 'uses' => 'TabletController@closeSuccess'));

Route::post('prediction/create', array('before' => 'auth', 'uses' => 'PredictionController@create'));
Route::post('prediction/edit', array('before' => 'auth', 'uses' => 'PredictionController@edit'));
Route::post('prediction/delete', array('before' => 'auth', 'uses' => 'PredictionController@delete'));

Route::post('expense/create', array('before' => 'auth', 'uses' => 'ExpenseController@create'));

Route::post('income/create', array('before' => 'auth', 'uses' => 'IncomeController@create'));

Route::post('economy/create', array('before' => 'auth', 'uses' => 'EconomyController@create'));


Route::get('login/fb', function() {
    $facebook = new Facebook(Config::get('facebook'));
    $params = array(
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'email',
    );
    return Redirect::to($facebook->getLoginUrl($params));
});

Route::get('login/fb/callback', function() {
    $code = Input::get('code');
    if (strlen($code) == 0)
        return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');

    $facebook = new Facebook(Config::get('facebook'));
    $uid = $facebook->getUser();

    if ($uid == 0)
        return Redirect::to('/')->with('message', 'There was an error');

    $me = $facebook->api('/me');

    $profile = Profile::whereUid($uid)->first();
    if (empty($profile)) {
        //check if there is a user registered on clasic way
        $user = User::whereEmail($me['email'])->first();
        if ($user) {
            $profile = new Profile();
            $profile->uid = $uid;
            $profile->username = $me['username'];
            $profile = $user->profiles()->save($profile);
        } else {
            $user = new User();
            // $user->name = $me['first_name'] . ' ' . $me['last_name'];
            $user->email = $me['email'];
            // $user->photo = 'https://graph.facebook.com/' . $me['username'] . '/picture?type=large';

            $user->save();

            $profile = new Profile();
            $profile->uid = $uid;
            $profile->username = $me['username'];
            $profile = $user->profiles()->save($profile);
        }
    }

    $profile->access_token = $facebook->getAccessToken();
    $profile->save();

    $user = $profile->user;

    Auth::login($user);

    return Redirect::to('dashboard')->with('message', 'Logged in with Facebook');
});

Route::get('how-to', array('uses' => 'PageController@howto'));

Route::post('password/remind', function() {
    $credentials = array('email' => Input::get('email'));

    return Password::remind($credentials);
});
Route::get('password/remind', array('before' => 'guest', 'uses' => 'AccountController@passwordRemind'));



Route::get('password/reset/{token}', function($token) {
    return View::make('account/reset-password')->with('token', $token);
});

Route::post('password/reset/{token}', function() {
    $credentials = array(
        'email' => Input::get('email'),
        'password' => Input::get('password'),
        'password_confirmation' => Input::get('password_confirmation')
    );

    return Password::reset($credentials, function($user, $password) {

            $user->password = Hash::make($password);
            $user->save();

            return Redirect::to('/');
        });
});
