<?php
namespace Cloudoki\OaStack\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model as Eloquent;



class Oauth2Client extends Eloquent
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
		return $this->hasOne('App\Models\User');
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

	/**
	 *	Schema
	 *	Filter response, based on schema.json and display type
	 *
	 * @param $display
	 * @return object
	 * @throws MissingParameterException
	 * @throws MissingSchemaException
	 */
	public function schema ($display)
	{
		$rules = (array) self::getSchema ($this::type . '.json');
		$response = array();

		// Validate
		if (!$display || !$rules)

			throw new MissingParameterException ('Schema mismatch or display parameter missing');

		// Return id
		if ($display == 'id')

			return $this->getId ();

		// Evaluate schema
		foreach ($rules [$display] as $key => $funcpair)
		{
			$func = explode (':', $funcpair);

			$response[$key] = $this::$func[0] (isset ($func[1])? $func[1]: null, isset ($func[2])? $func[2]: null);
		}

		return (object) $response;
	}

	/**
	 * Get Seed Content
	 * Retreive content from schema seed file
	 *
	 * @param $filename
	 * @return mixed
	 * @throws MissingSchemaException
	 */
	protected static function getSchema ($filename)
	{
		// Get schema file
		$file = __DIR__.'/schemes/' . $filename;

		if (!file_exists ($file))

			throw new MissingSchemaException ('Schema file not found');

		else return json_decode (file_get_contents ($file));
	}

	/**
	 *	Get Constant
	 *	Get constant defined on model
	 *
	 *	@return const mixed
	 */
	public function getConst ($name)
	{
		$model = new ReflectionClass ($this);

		return $model->getConstant($name);
	}
}