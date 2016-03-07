<?php
namespace Cloudoki\OaStack\Models;

use Cloudoki\OaStack\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cloudoki\OaStack\Models\BaseModel;



class Oauth2Client extends BaseModel
{
	/**
	 * The model type.
	 *
	 * @const string
	 */
	const type = 'oauth2client';

	const success = true;

	protected $table = 'oauth_clients';

	/**
	 * Since we're using an existing db and Eloquent expects us to have (by default)
	 * the updated_at, created_at columns, we need to disable the automatic timestamp updates
	 * on this model
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}
	/**
	 *	Append Payload
	 *
	 *	@param	object	$payload
	 *	@return self
	 */
	public function appendPayload ($payload)
	{
		$this->setClientId ();
		$this->setClientSecret ();
		
		$this->users()->attach((int) $payload->user_id);
		$this->setName ($payload->name);
		$this->setRedirectUri ($payload->redirect);

		return $this;
	}

	public function user ()
	{
		return $this->hasOne(User::class);
	}

	/**
	 *	Get Id
	 *	@return string
	 */
	public function getClientId ()
	{
		return $this->client_id;
	}

	/**
	 *	Set Client Id
	 *	Generate (and overwrite) client id
	 */
	public function setClientId ()
	{
		$this->client_id = uniqid ('oauth2', true);
		
		return $this;
	}

	/**
	 *	Get Client Secret
	 *
	 *	@return string
	 */
	public function getClientSecret ()
	{
		return $this->client_secret;
	}

	/**
	 *	Set Client Secret
	 *	Generate (and overwrite) md5 hashed secret
	 */
	public function setClientSecret ()
	{
		$this->client_secret = md5 (uniqid ('secret'));
		
		return $this;
	}

	/**
	 *	Get Name
	 *
	 *	@return string
	 */
	public function getName ()
	{
		return $this->client_name;
	}

	/**
	 *	Set Name
	 *	Set (140char max) string name
	 */
	public function setName ($name)
	{
		$this->client_name = $name;
		
		return $this;
	}

	/**
	 *	Get Redirect Uri
	 *
	 *	@param	string	$token
	 *	@return string
	 */
	public function getRedirectUri ($token = null)
	{
		return $this->redirect_uri . ($token? '?access_token=' . $token: '');
	}

	/**
	 *	Set Redirect Uri
	 *	Set string redirect uri
	 */
	public function setRedirectUri ($uri)
	{
		$this->redirect_uri = $uri;
		
		return $this;
	}

	/**
	 *	Get User
	 *
	 *	@return mixed
	 */
	public function getUser ($display)
	{
		$user = $this->user();

		return $display?

			$user:
			$user->schema ($display);
	}
}