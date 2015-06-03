<?php namespace Cloudoki\OaStack;

use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\RefreshToken;
use OAuth2\Request;
use OAuth2\Server;
use OAuth2\Storage\Pdo;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;

class Oauth2Verifier
{
	public static function getInstance ()
	{
		static $in;
		if (!isset ($in))
		{
			$in = new self ();
		}
		return $in;
	}

	private $request;
	private $requestbody;

	/**
	 * @var \OAuth2\Server
	 */
	private $server;

	private $user;
	private $token;
	private $valid;

	private function __construct ()
	{
		// Database	
		$db = (object) Config::get('database.connections.mysql');
		$dsn = 'mysql:dbname='.$db->database.';host='.$db->host;
		
		$pdoconfig = array
		(
			'client_table' => 'oauth_clients',
			'access_token_table' => 'oauth_access_tokens'
		);

		$storage = new Pdo (array('dsn' => $dsn, 'username' => $db->username, 'password' => $db->password), $pdoconfig);
		
		$this->server = new Server($storage, array (
			'allow_implicit' => true,
			'enforce_redirect' => true,
			'access_lifetime' => 3600 * 24 * 365 * 2
		));

		$this->server->addGrantType (new AuthorizationCode($storage));

		$this->server->addGrantType (new RefreshToken ($storage, array (
			'always_issue_new_refresh_token' => true,
			'refresh_token_lifetime' => 3600 * 24 * 31 * 2
		)));
	}

	/**
	 * @return Server
	 */
	public function getServer ()
	{
		return $this->server;
	}

	/**
	 *	@return Request
	 */
	public function getRequest ()
	{
		if (!isset ($this->request))
		{
			$this->request = $this->createRequestFromGlobals();
		}

		return $this->request;
	}
	
	public function createRequestFromGlobals()
    {
		// Patch headerless bearer
		$headers = Input::get('access_token')?
		
			array ('AUTHORIZATION'=> 'Bearer ' . Input::get('access_token')): null;

		
		$request = new Request($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER, Input::all(), $headers);

        return $request;
    }
	
	

	public static function isValid ()
	{
		$instance = self::getInstance ();

		if (!isset ($instance->valid))
		{
			$request = $instance->getRequest ();

			$instance->requestbody = $request->getContent ();

			$instance->valid = $instance->getServer ()->verifyResourceRequest($request);

			if ($instance->valid)
			{
				$token = $instance->server->getAccessTokenData($request);
				$instance->token = $token['access_token'];
				$instance->user = $token['user_id'];
			}
		}

		return $instance->valid;
	}

	/**
	 *	Get User Id
	 */
	public static function getUserID ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return $instance->user;
		}
		return false;
	}
	
	/**
	 *	Get User Object
	 */
	public static function getUser ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return \User::find ($instance->user);
		}
		return false;
	}
	
	public function getRequestBody ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return $instance->requestbody;
		}
	}

	public static function getToken ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return $instance->token;
		}
	}
}