<?php

namespace Cloudoki\OaStack\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 *	Account Model
 *	Add the namespace if you want to extend your custom Account model with this one.
 */



class Account extends Eloquent {

	use SoftDeletingTrait;

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
		return $this->belongsToMany ('App\Models\User')->withPivot ('invitation_token');
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
