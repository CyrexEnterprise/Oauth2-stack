<?php

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
	 *	Append Payload
	 *
	 *	@param	object	$payload
	 *	@return self
	 */
	public function appendPayload ($payload)
	{	
		$this->setClientId ();
		$this->setClientSecret ();
		$this->setUser ();

		$this->setName ($payload->name);
		$this->setRedirectUri ($payload->redirect);
		
		return $this;
	}
	
	/**
	 * Define the attributes that are mass assignable - security reasons.
	 * Only this attributes can be changed.
	 *
	 * @var array
	 */
	// protected $fillable = array();

	public function user ()
	{
		return $this->hasOne('User');
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
		return $this->client_id = uniqid ('oauth2', true);
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
		return $this->client_secret = md5 (uniqid ('secret'));
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
		if (!$name || !is_string ($name))
		
			throw new MissingParameterException ('an valid (string) name is required');
		
		$this->client_name = $name;
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
		if (!$uri || !is_string ($uri))
		
			throw new MissingParameterException ('an valid uri is required');
		
		$this->redirect_uri = $uri;
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
	 *	Set User
	 *	Current user is set as app user. Easy to improve to any (exist confirmed) user.
	 *
	 *	@param	int	$id
	 */
	public function setUser ($id)
	{
		$userid = (int) $id?: Guardian::user ()->getKey();
		
		if (!$userid)
		
			throw new MissingParameterException ('an existing User ID is required');
		
		$this->user_id = $userid;
		
		return this;
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
		$file = Config::get('oastack::schemas.path') . $filename;
		
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
};