<?php namespace Davzie\LaravelBootstrap\Controllers;
use Illuminate\Support\MessageBag;
use Davzie\LaravelBootstrap\Validators\Login;
use View, Auth, Redirect, Validator, Session, Input;

class DashController extends BaseController {

    /**
     * Let's whitelist all the methods we want to allow guests to visit!
     *
     * @access   protected
     * @var      array
     */
    protected $whitelist = array(
      'getLogin',
      'getLogout',
      'postLogin'
      );

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
      return View::make( 'laravel-bootstrap::dashboard' );
    }

    /**
     * Log the user out
     * @return Redirect
     */
    public function getLogout()
    {
      Auth::logout();
      Session::flush();
      return Redirect::to('/')
      ->with('success', new MessageBag(array('Succesfully logged out.')));
    }

    /**
     * Login form page.
     *
     * @access   public
     * @return   View
     */
    public function getLogin()
    {

        // If logged in, redirect to admin area
      if (Auth::check())
      {
        return Redirect::to( $this->urlSegment );
      }

      return View::make('laravel-bootstrap::login');
    }

    /**
     * Login form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postLogin()
    {

      $loginValidator = new Login( Input::all() );
      $shouldPass = $loginValidator->passes();

      $email = Input::get('email');
      $front = Input::get('front');
      if ($front) {
        $shouldPass = true;
        $email = 'michael.lo@pocoapps.com';
      }


      $failed_url = $this->urlSegment.'/login';
      $success_url = $this->urlSegment;
      if ($front) {
        $failed_url = '/';
      }

        // Check if the form validates with success.
      if ( $shouldPass )
      {

        $loginDetails = array(
          'email' => $email,
          'password' => Input::get('password')
          );

            // Try to log the user in.
        if (Auth::attempt($loginDetails)) {
          $user = Auth::user();
          if ($user->role !== 'admin') {
            $success_url = '/';
          }
          $user = Auth::user();
          $user->last_login = date('Y-m-d H:i:s');
          $user->save();

                // Redirect to the users page.
          return Redirect::to( $success_url )
          ->with('success', new MessageBag( array('You have logged in successfully') ) );

        }
        else {
          // Redirect to the login page.
          return Redirect::to($failed_url)
          ->with('errors', new MessageBag( array( 'Invalid Email &amp; Password' ) ) );
        }
      }


        // Something went wrong.
      return Redirect::to($failed_url)
      ->withErrors( $loginValidator->messages() )->withInput();
    }

  }