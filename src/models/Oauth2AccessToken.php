<?php namespace Cloudoki\OaStack;

class Oauth2AccessToken extends Eloquent
{
	/**
	 * The model type.
	 *
	 * @const string
	 */
	protected $table = 'oauth_access_tokens';
	
	protected $guarded = array('scope');
	
	/**
	 * Since we're using an existing db and Eloquent expects us to have (by default)
	 * the updated_at, created_at columns, we need to disable the automatic timestamp updates
	 * on this model
	 *
	 * @var bool
	 */
	public $timestamps = false;
	

	/**
	 * User relationship
	 *
	 * @return BelongsToMany
	 */
	public function user ()
	{
		return $this->belongsTo ('User');
	}
	
	/**
	 * Client relationship
	 *
	 * @return BelongsToMany
	 */
	public function client ()
	{
		return $this->belongsTo ('Oauth2Client', 'client_id', 'client_id');
	}
	
	/**
	 *	Only Valids
	 *
	 *	@param	object	$query
	 *
	 *	@return	object
	 */
	public function scopeValid ($query)
	{
		return $query->whereRaw ('expires > now()');
	}
	
	/**
	 *	Only Valids, with token
	 *
	 *	@param	object	$query
	 *	@param	object	$client
	 *
	 *	@return	object
	 */
	public function scopeValidated ($query, $token)
	{
		return $query->where ('access_token', $token)
					 ->whereRaw ('expires > now()');
	}
	
	/**
	 *	Only Valids, with client
	 *
	 *	@param	object	$query
	 *	@param	object	$client
	 *
	 *	@return	object
	 */
	public function scopeValidWithClient ($query, $client)
	{
		return $query->where ('client_id', $client->getClientId ())
					 ->whereRaw ('expires > now()');
	}
	
	
	/**
	 *	Get Token
	 *
	 *	@return	string
	 */
	public function getToken ()
	{
		return $this->access_token;
	}
	
	
	/**
     * Generates an unique access token.
     *
     * Implementing classes may want to override this function to implement
     * other access token generation schemes.
     *
     * @return
     * An unique access token.
     *
     * @ingroup oauth2_section_4
     */
	protected static function generateAccessToken()
	{
		if (function_exists('mcrypt_create_iv')) 
		{
			$randomData = mcrypt_create_iv(20, MCRYPT_DEV_URANDOM);
			if ($randomData !== false && strlen($randomData) === 20)
			
				return bin2hex($randomData);
		}
		
		if (function_exists('openssl_random_pseudo_bytes'))
		{
			$randomData = openssl_random_pseudo_bytes(20);
			if ($randomData !== false && strlen($randomData) === 20)
			
				return bin2hex($randomData);
		}
		
		if (@file_exists('/dev/urandom')) 
		{
			$randomData = file_get_contents('/dev/urandom', false, null, 0, 20);
			if ($randomData !== false && strlen($randomData) === 20)
				
				return bin2hex($randomData);
		}
		
		# Last resort
		$rand = ['potatoes', 'peaches', 'tomatoes', 'onions', 'bananas', 'watermelon', 'lettuce', 'grapes', 'peppers', 'artichokes'];

		return md5 (uniqid ( $rand[rand (0, 9)] . ' ' . $rand[rand (0, 9)], true)) . substr(uniqid ($rand[rand (0, 9)]), 0, 8);
	}
};