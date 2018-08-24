<?php

namespace Cloudoki\OaStack\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Cloudoki\InvalidParameterException;
use Cloudoki\OaStack\Exceptions\Handler as OaStackHandler;

class OaStackViewController extends BaseController {

	protected static $loginRules = array
	(
		'email'=> 'required|email',
		'password'=> 'required|min:4',
		'client_id'=> 'required|min:18',
		'response_type'=> 'required|min:4',
		'redirect_uri'=> 'required|min:8',
		'state'=> ''
	);

	protected static $resetRules = array
	(
		'email'=> 'required|email',
	);

	protected static $changepasswordRules = array
	(
		'reset_token'=> 'required|size:32',
		'email'=> 'required|email',
		'password'=> 'required|min:6',
		'password_confirmation'=> 'required|min:6'
	);

	protected static $approveRules = array
	(
		'session_token'=> 'required|min:18',
		'approve'=> '',
	);

	protected static $invitationRules = array
	(
		'token'=> 'required|size:32'
	);

	protected static $subscribeRules = array
	(
		'token'=> 'required|size:32',
		'firstname'=> 'required|min:2',
		'lastname'=> 'required|min:2',
		'email'=> 'required|email',
		'password'=> 'required|min:6'
	);

	protected static $postRules = array
	(
		'name'=> 'required|min:4',
		'redirect'=> 'required|url',
		'user_id' => 'required|integer',
	);

	public function __construct (Request $request)
	{
		parent::__construct($request);
		// Override the base app's global exception handler with this
		// package's custom exception handler
		// As seen here: https://laracasts.com/discuss/channels/requests/custom-exception-handler-based-on-route-group
		\App::singleton(
			\Illuminate\Contracts\Debug\ExceptionHandler::class,
			OaStackHandler::class
		);
	}

	/**
	 *	User Login
	 *	Show user login fields
	 */
	public function login ()
	{
		// Build View
		return view ('oastack::oauth2.login');
	}

	/**
	 *	User Login
	 *	Redirect success or show failure.
	 */
	public function loginrequest ()
	{
        try
        {
            // Request Foreground Job
            $login = $this->restDispatch ('login', 'Cloudoki\OaStack\OAuth2Controller', [], self::$loginRules);
        }
        catch (ValidationException $e)
        {
            return view('oastack::oauth2.login', ['error'=> isset ($login->message)? $login->message: "something went wrong"]);
        }
        
        return isset ($login->view)?
            
            view ('oastack::oauth2.' . $login->view, (array) $login):
            redirect()->away($login->uri);
	}

	/**
	 *	User Forgot
	 *	Show user forgot fields
	 */
	public function forgot ()
	{
		// Build View
		return view ('oastack::oauth2.forgot');
	}

	/**
	 *	User Forgot
	 *	Redirect success or show failure.
	 */
	public function resetrequest ()
	{
		// Request Foreground Job
		$login = $this->restDispatch ('resetpassword', 'Cloudoki\OaStack\OAuth2Controller', [], self::$resetRules);

		if (isset ($login->error))

			return view('oastack::oauth2.forgot', ['error'=> $login->message]);


		return redirect()->route('login');
	}

	/**
	 *	User Reset Form
	 *	Show user reset fields
	 */
	public function reset ($token)
	{
		// Build View
		return view ('oastack::oauth2.reset', ['reset_token'=> $token]);
	}

	/**
	 *	Perform User Reset
	 *	Show user reset result
	 *
	 *	@param	string	$token
	 */
	public function changepassword ($token)
	{
		// Request Foreground Job
		$reset = $this->restDispatch ('changepassword', 'Cloudoki\OaStack\OAuth2Controller', ['reset_token'=> $token], self::$changepasswordRules);

		if (isset ($reset->error))

			return view('oastack::oauth2.reset', ['error'=> $reset->message]);

		if (config('oastack.redirect_url'))

			return redirect()->away(config('oastack.redirect_url'));

		return redirect()->route('login');
	}

	/**
	 *	User Authorize
	 *	Redirect success or show failure.
	 */
	public function approve ()
	{
		// Request Foreground Job
		$login = $this->restDispatch ('authorize', 'Cloudoki\OaStack\OAuth2Controller', [], self::$approveRules);
		if (isset ($login->error))

			return view('oastack::oauth2.login', ['error'=> $login->message]);


		return redirect()->away($login->uri);
	}

	/**
	 *	User Invite Form
	 *	Show user invite fields
	 */
	public function invite ()
	{
		// Accounts list
		$accounts = $this->restDispatch ('accounts', 'Cloudoki\OaStack\OAuth2Controller');

		// Build View
		return view ('oastack::oauth2.invite', ['accounts'=> $accounts]);
	}

	/**
	 *	Subscribe User
	 *	Show user registration
	 *
	 *	@param	string	$token
	 */
	public function subscribe ($token)
	{
		// Request Foreground Job
		$invite = $this->restDispatch ('identifyinvite', 'Cloudoki\OaStack\OAuth2Controller', ['token'=> $token], self::$invitationRules);


		// Build View
		return view ('oastack::oauth2.subscribe',
		[
			'user'=> (array) $invite->user,
			'account'=> (array) $invite->account
		]);
	}

	/**
	 *	Subscribed User
	 *	Show success or failure.
	 *
	 *	@param	string	$token
	 */
	public function subscribed ($token)
	{
		try
		{
			// Request Foreground Job
			$response = $this->restDispatch ('subscribe', 'Cloudoki\OaStack\OAuth2Controller', ['token'=> $token], self::$subscribeRules);
		}
		catch (Exception $e)
		{
			$response = ['errors'=> $e->getErrors ()];
		}

		// Build View
		return view('oastack::oauth2.subscribed', (array) $response);
	}

	/**
	 *	Register App View
	 *	Show client app registration
	 */
	public function registerapp ()
	{
		// Build View
		return view ('oastack::oauth2.register');
	}

	/**
	 *	Registered App View
	 *	Show client app action response
	 */
	public function registeredapp ($response = array())
	{

		try
		{
			// Request Foreground Job
			$response = $this->restDispatch ('registerclient', 'Cloudoki\OaStack\OAuth2Controller', [], self::$postRules);
		}
		catch (Exception $e)
		{
			$response = ['error'=> $e->getErrors ()];
		}

		// Build View
		return view('oastack::oauth2.registered', (array) $response);
	}
}
