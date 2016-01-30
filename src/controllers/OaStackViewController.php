<?php
	
namespace Cloudoki\OaStack;

use Validator;
use Illuminate\Http\Request;
use Cloudoki\OaStack\BaseController;

class OaStackViewController extends BaseController {
	
	protected static $loginRules = array
	(	
		'email'=> 'required|email',
		'password'=> 'required|min:4',
		'client_id'=> 'required|min:18',
		'response_type'=> 'required|min:5',
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
		'redirect'=> 'required|url'
	);
	
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
		// Request Foreground Job
		$login = json_decode ($this->restDispatch ('login', 'OAuth2Controller', [], self::$loginRules));
		
		if (isset ($login->error))
		
			return view('oastack::oauth2.login', ['error'=> $login->message]);
		
		else if (isset ($login->view))
			
			return view ('oastack::oauth2.' . $login->view, (array) $login);
		

		return Redirect::away($login->uri);
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
		$login = json_decode ($this->restDispatch ('resetpassword', 'OAuth2Controller', [], self::$resetRules));
		
		if (isset ($login->error))
		
			return view('oastack::oauth2.forgot', ['error'=> $login->message]);
		

		return Redirect::route('login');
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
		$reset = json_decode (self::restDispatch ('changepassword', 'OAuth2Controller', ['reset_token'=> $token], self::$changepasswordRules));

		if (isset ($reset->error))
		
			return view('oastack::oauth2.reset', ['error'=> $reset->message]);
	
		return Redirect::route('login');
	}
	
	/**
	 *	User Authorize
	 *	Redirect success or show failure.
	 */
	public function approve ()
	{
		// Request Foreground Job
		$login = json_decode (self::restDispatch ('authorize', 'OAuth2Controller', [], self::$approveRules));

		if (isset ($login->error))
		
			return view('oastack::oauth2.login', ['error'=> $login->message]);
		
		
		return Redirect::away($login->uri);
	}
	
	/**
	 *	User Invite Form
	 *	Show user invite fields
	 */
	public function invite ()
	{
		// Accounts list
		$accounts = json_decode (self::restDispatch ('accounts', 'OAuth2Controller'));		
		
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
		$invite = self::restDispatch ('identifyinvite', 'OAuth2Controller', ['token'=> $token], self::$invitationRules);
		
		// Build View
		return view ('oastack::oauth2.subscribe', json_decode ($invite, true));
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
			$response = json_decode (self::restDispatch ('subscribe', 'OAuth2Controller', ['token'=> $token], self::$subscribeRules), true);
		}
		catch (InvalidParameterException $e)
		{
			$response = ['errors'=> $e->getErrors ()];
		}
		
		// Build View
		return view('oastack::oauth2.subscribed', $response);
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
			$response = json_decode (self::restDispatch ('registerclient', 'OAuth2Controller', [], self::$postRules), true);
		}
		catch (InvalidParameterException $e)
		{
			$response = ['error'=> $e->getErrors ()];
		}
		
		// Build View
		return view('oastack::oauth2.registered', $response);
	}
}
