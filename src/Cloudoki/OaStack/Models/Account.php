<?php

namespace Cloudoki\OaStack\Models;

use Cloudoki\OaStack\Models\User;
use Cloudoki\OaStack\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *	Account Model
 *	Add the namespace if you want to extend your custom Account model with this one.
 */
class Account extends BaseModel
{
	use SoftDeletes;
	
	/**
	 * The model type.
	 *
	 * @const string
	 */
	const type = 'account';

	/**
	 * Fillables
	 * define which attributes are mass assignable (for security)
	 *
	 * @var array
	 */
	protected $fillable = array('name');

	protected $dates = ['deleted_at'];

	/**
	 * Users relationship
	 *
	 * @return BelongsToMany
	 */
	public function users ()
	{
		return $this->belongsToMany (User::class)->withPivot ('invitation_token');
	}

	/**
	 * Get account name
	 *
	 * @return	string
	 */
	public function getName ()
	{
		return $this->name;
	}

	/**
	 * Set account name
	 *
	 * @param	string	$name
	 */
	public function setName ($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 *	Get Invitation Token
	 *
	 *	@return int
	 */
	public function getInvitationToken ()
	{
		return $this->pivot->invitation_token;
	}
}
