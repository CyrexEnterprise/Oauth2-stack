<?php

namespace Cloudoki\OaStack;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Cloudoki\OaStack\Oauth2Verifier;
use OAuth2\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Exception\InvalidParameterException;


class OaStack
{

	/**
	 *	Allowed
	 *	Is the user allowed? Valid access token,
	 *	account relation and user roles can be checked
	 *
	 *	@return boolean
	 */
	public static function allowed ($accountid = null, $roles = array())
	{
		return !
		(
			// Is there an access token?
			!Input::get ('access_token') ||

			// Is the acces token valid?
			!self::validAccess () ||

			// Is the user and account connected?
			($accountid && !self::accountRelation ($accountid)) ||

			// Has the user the required roles for the account?
			($accountid && count($roles) && !self::hasRoles ($accountid, $roles))
		);
	}

	/**
	 *	Check
	 *	Perform allow function, throw exception if not allowed.
	 *
	 *	@return void
	 *	@throws AccessDeniedHttpException
	 */
	public static function check ($accountid = null, $roles = array())
	{
		if (!self::allowed($accountid, $roles))

			throw new AccessDeniedHttpException ();
	}

	/**
	 *	User
	 *	Show current user.
	 *
	 *	@return User
	 */
	public static function user ()
	{
		return Oauth2Verifier::getUser ();
	}

	/**
	 *	Valid access
	 *	Make sure the user has a valid access token.
	 *
	 *	@return boolean
	 */
	public static function validAccess ()
	{
		return Oauth2Verifier::isValid();
	}

	/**
	 *	Account Relation
	 *	Make sure the user is related to the account.
	 *
	 *	the where $apk function should be a find function. Look for new Eloquent versions solving the current bug.
	 *
	 *	@return boolean
	 *	@throws InvalidParameterException
	 */
	public static function accountRelation ($id)
	{
		if (!is_int ($id))

			throw new InvalidParameterException ('an integer ID is required');

		// User contains account
		return self::user ()-> accounts->contains ($id);
	}

	/**
	 *	Has Roles
	 *	Make sure the user has all the required roles for the related account.
	 *
	 *  @param  int		$id			Account id to retreive rolesset from
	 *  @param  string	$role		Required role
	 *	@return boolean
	 *	@throws InvalidParameterException
	 *
	 *	User vs Account rolesset as array:
	 *	return count ($roles) === count (array_intersect (self::user()->getRoles ($id), $roles));
	 *
	 */
	public static function hasRoles ($id, $role)
	{
		if(!isset ($role) || !is_string ($role))

			throw new InvalidParameterException ('Invalid roletokens container type');


		// User vs Account rolesset
		return in_array ($role, self::user()->getRoles ($id));
	}
}
