<?php

/**
 * Account controller class
 * This class is responsible for user account operations
 *
 * @author Andrei Boar <andrey.boar@gmail.com>
 */
class AccountController extends BaseController
{

    public function index()
    {
        return Redirect::to('account/create');
    }

    public function login()
    {
        return View::make('account/login');
    }

    public function loginPost()
    {
        $postData = Input::all();

        $rules = array(
            'email' => array('required', 'email'),
            'password' => array('required'),
        );

        $messages = array(
            'email.required' => 'Please enter your e-mail.',
            'email' => 'Please enter a valid e-mail.',
            'password.required' => 'Please enter your password.',
        );

        $validator = Validator::make($postData, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('account/login')
                    ->withErrors($validator)
                    ->with('email', $postData['email']);
        }

        $rememberMe = (isset($postData['remember']) && $postData['remember'] == 1) ? true : false;

        if (Auth::attempt(array('email' => $postData['email'], 'password' => $postData['password']), $rememberMe)) {
            return Redirect::intended('dashboard');
        }

        return Redirect::to('account/login')->with('loginFailed', true);
    }

    /**
     * User registration page
     * @return string
     */
    public function create()
    {
        return View::make('account/create');
    }

    /**
     * Create post action
     * @return string
     */
    public function createPost()
    {
        $postData = Input::all();

        $rules = array(
            'email' => array('required', 'email', 'unique:users'),
            'password1' => array('required', 'min:6'),
            'password2' => array('required', 'min:6', 'same:password1')
        );
        $messages = array(
            'email.required' => 'Please enter your e-mail.',
            'email' => 'Please enter a valid e-mail.',
            'password1.required' => 'Please enter your password.',
            'password2.required' => 'Please re-type your password.',
            'min' => 'The password must have at least 6 characters.',
            'password2.same' => 'Password fields don\'t match.'
        );

        $validator = Validator::make($postData, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('account/create')
                    ->withErrors($validator)
                    ->with('email', $postData['email']);
        }

        $user = new User();
        $user->email = $postData['email'];
        $user->password = Hash::make($postData['password1']);
        $user->confirmation = null;
        $user->save();

        return Redirect::to('account/success');
    }

    public function logOut()
    {
        Auth::logout();

        return Redirect::to('/');
    }

    /**
     * Success page after user registration
     * @return string
     */
    public function success()
    {
        return View::make('account/success');
    }

}