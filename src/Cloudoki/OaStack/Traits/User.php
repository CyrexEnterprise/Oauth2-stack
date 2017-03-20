<?php

namespace Cloudoki\OaStack\Traits;

use Illuminate\Support\Facades\Hash;

trait User {

	/**
	 * Get a user by its main username/email identifier.
	 *
	 * @return hasMany
	 */
	public static function findByLoginId($identifier) {
		return self::where('email', '=', $identifier)->first();
	}

	/**
	 * Acces Token relationship
	 *
	 * @return hasMany
	 */
	public function oauth2accesstokens ()
	{
		return $this->hasMany('Cloudoki\OaStack\Models\Oauth2AccessToken');
	}

	/**
	 * Authorisations relationship
	 *
	 * @return hasMany
	 */
	public function oauth2authorizations ()
	{
		return $this->hasMany('Cloudoki\OaStack\Models\Oauth2Authorization');
	}

	/**
	 * Clients relationship
	 *
	 * @return hasMany
	 */
	public function oauth2clients ()
	{
		return $this->hasMany('Cloudoki\OaStack\Models\Oauth2Client');
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
	 * Return an object with the most important user properties
	 * which will be used for the view templates.
	 * The object must contain at least the following properties:
	 * - id
	 * - email
	 * - firstname
	 * - lastname
	 * - fullname
	 */
	public function getViewPresenter () {
		$user = $this->schema ('basic');
		$user->fullname = $user->firstname . '  ' . $user->lastname;

		return $user;
	}
}