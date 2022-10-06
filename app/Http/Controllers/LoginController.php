<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * User login rules
     *
     * @var array
     */
    protected $rules = [
        'username' => 'required',
        'password'=> 'required'
    ];

    /**
     * User login feedback
     *
     * @var array
     */
    protected $feedback = [
        'required' => 'attribute :attribute is required'
    ];

    /**
     * render login page.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_SESSION)) session_start();
        return view('login');
    }

    /**
     * Authenticate user if username and password match.
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (!isset($_SESSION)) session_start();

        $_SESSION['id'] = $request->get('userid');
        $_SESSION['name'] = $request->input('username');

        return redirect()->route('home');
    }

    /**
     * Logout user and unset SESSION variable
     *
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        if (!isset($_SESSION)) session_start();

        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION);

        return redirect()->route('welcome');
    }
}
