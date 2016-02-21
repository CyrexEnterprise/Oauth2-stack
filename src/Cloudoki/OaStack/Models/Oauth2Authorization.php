<?php
namespace Cloudoki\OaStack\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Oauth2Authorization extends Eloquent
{
	/**
	 * The model type.
	 *
	 * @const string
	 */
	const type = 'oauth2authorization';

	protected $table = 'oauth_authorizations';

	protected $fillable = ['client_id', 'user_id', 'authorization_date'];

	/**
	 * Since we're using an existing db and Eloquent expects us to have (by default)
	 * the updated_at, created_at columns, we need to disable the automatic timestamp updates
	 * on this model
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Users relationship
	 *
	 * @return BelongsToMany
	 */
	public function user ()
	{
		return $this->belongsTo ('User');
	}
};