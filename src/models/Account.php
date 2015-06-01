<?php

class Account extends BaseModel {

	use SoftDeletingTrait;

	/**
	 * Fillables
	 * define which attributes are mass assignable (for security)
	 *
	 * @var array
	 */
	protected $fillable = array('unique', 'name');
	
    protected $dates = ['deleted_at'];
    
	/**
	 * Users relationship
	 *
	 * @return BelongsToMany
	 */
	public function users ()
	{
		return $this->belongsToMany ('User');
	}
	
	/**
	 * Get account id
	 *
	 * @return	int
	 */
	public function getId ()
	{
		return (int) $this->id;
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
	 * Get account unique name
	 *
	 * @return	string
	 */
	public function getUnique ()
	{
		return $this->unique;
	}
	
	/**
	 * Set account unique name
	 *
	 * @param	string	$unique
	 */
	public function setUnique ($unique)
	{
		$this->unique = $unique;
		
		return $this;
	}
	
	/**
	 * Get Users
	 * All users related to the account.
	 *
     * @param $display
     * @return array
     */
	public function getUsers ($display)
	{
		# Get related users
		return $this->users->schema ($display);
	}

	/**
	 *	Get Active
	 *
	 *	@return int
	 */
	public function getActive ()
	{
		return $this->active;
	}
	
	/**
	 *	Set Active
	 *
	 *	@param	int		$active
	 *	@return self
	 */
	public function setActive ($active)
	{
		$this->active = $active;
		
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
