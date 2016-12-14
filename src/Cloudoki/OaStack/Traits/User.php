<?php

namespace Cloudoki\OaStack\Traits;

use Illuminate\Support\Facades\Hash;

trait User {

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

}