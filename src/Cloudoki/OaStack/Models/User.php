<?php
namespace Cloudoki\OaStack\Models;

use Cloudoki\OaStack\Models\BaseModel;
use Cloudoki\OaStack\Models\Oauth2Authorization;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Cloudoki\OaStack\Traits\User as UserTrait;

/**
 *	User Model
 *	Add the namespace if you want to extend your custom User model with this one.
 */
class User extends BaseModel
{
	use SoftDeletes;
	use UserTrait;

	/**
	 * The model type.
	 *
	 * @const string
	 */
	const type = 'user';

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
		return $this->belongsToMany ('Cloudoki\OaStack\Models\Account')->withPivot ('invitation_token');
	}

	/**
	 * Get Accounts
	 * All accounts related to the user.
	 *
	 * @param   $display
	 * @return  array
	 */
	public function getAccounts ($display)
	{
		# Get related users
		return $this->accounts->schema ($display);
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

		return $this;
	}

	/**
	 * Get user name
	 *
	 * @return	string
	 */
	public function getLastName ()
	{
		return $this->lastname;
	}

	/**
	 * Set user name
	 *
	 * @param	string	$name
	 */
	public function setLastName ($name)
	{
		$this->lastname = $name;

		return $this;
	}

	/**
	 * Get user name
	 *
	 * @return	string
	 */
	public function getFullName ()
	{
		return $this->firstname . ' ' . $this->lastname;
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

		return $this;
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

		return $this;
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
		$account = $this->accounts->first();
		$this->accounts()->updateExistingPivot($account->getId (), ['reset_token'=> $token]);

		return $this;
	}
}