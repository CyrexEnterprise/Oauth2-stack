<?php
namespace Cloudoki\OaStack;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 *	User Model
 *	Add the namespace if you want to extend your custom User model with this one.
 */
class User extends Eloquent {

	//use SoftDeletingTrait;

	/**
	 * Fillables
	 * define which attributes are mass assignable (for security)
	 *
	 * @var array
	 */
	protected $fillable = array('firstname', 'lastname', 'email', 'avatar');

	protected $dates = ['deleted_at'];

	/**
	 * Accounts relationship
	 *
	 * @return BelongsToMany
	 */
	public function accounts ()
	{
		return $this->belongsToMany ('Account')->withPivot ('invitation_token');
	}

	/**
	 * Acces Token relationship
	 *
	 * @return hasMany
	 */
	public function oauth2accesstokens ()
	{
		return $this->hasMany('\Cloudoki\OaStack\Oauth2AccessToken');
	}

	/**
	 * Authoirzations relationship
	 *
	 * @return hasMany
	 */
	public function oauth2authorizations ()
	{
		return $this->hasMany('Oauth2Authorization');
	}

	/**
	 *	Find By Email
	 *
	 *	@param	object	$query
	 *	@param	string	$email
	 *
	 *	@return	object
	 */
	public function scopeEmail ($query, $email)
	{
		return $query->where('email', $email);
	}

	/**
	 * Check Reset Token
	 *
	 *	@param	object	$query
	 *	@param	string	$token
	 *
	 *	@return	object
	 */
	public function scopeResetToken ($query, $token)
	{
		return $query->where('reset_token', $token);
	}

	/**
	 * Get user first name
	 *
	 * @return	string
	 */
	public function getFirstName ()
	{
		return $this->firstname;
	}

	/**
	 * Set user name
	 *
	 * @param	string	$firstname
	 */
	public function setFirstName ($firstname)
	{
		$this->firstname = $firstname;
	}

	/**
	 * Get user name
	 *
	 * @return	string
	 */
	public function getLastName ()
	{
		return $this->name;
	}

	/**
	 * Set user name
	 *
	 * @param	string	$name
	 */
	public function setLastName ($name)
	{
		$this->name = $name;
	}

	/**
	 * Get user e-mail
	 *
	 * @return	string
	 */
	public function getEmail ()
	{
		return $this->email;
	}

	/**
	 * Set user e-mail
	 *
	 * @param	string	$email
	 */
	public function setEmail ($email)
	{
		$this->email = $email;
	}

	/**
	 * Set the value for the u_password.
	 *
	 * @param string $value
	 * @return void
	 */
	public function setPassword($value)
	{
		$this->password = Hash::make ($value);
	}

	/**
	 * Check password
	 *
	 * @param string $value
	 * @return bool
	 */
	public function checkPassword ($value)
	{
		return Hash::check ($value, $this->password);
	}

	/**
	 *	Get Avatar
	 *
	 *	@return string
	 */
	public function getAvatar()
	{
		return $this->avatar;
	}

	/**
	 *	Set Active
	 *
	 *	@param	int		$active
	 *	@return self
	 */
	public function setAvatar($url)
	{
		$this->avatar = $url;

		return $this;
	}

	/**
	 *	Make Token
	 *
	 *	@return string
	 */
	public function makeToken ()
	{
		$rand = ['pork', 'belly', 'hadakamugi', 'tuna', 'ninja', 'breakfast', 'storm', 'napkin', 'bunny', 'domination'];

		return md5 (uniqid ( $rand[rand (0, 9)] . ' ' . $rand[rand (0, 9)], true));
	}

	/**
	 *	Set Reset Token
	 *
	 *	@param	string	$token
	 *	@return self
	 */
	public function setResetToken ($token)
	{
		$this->reset_token = $token;

		return $this;
	}
}
