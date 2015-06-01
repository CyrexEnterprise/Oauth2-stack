<?php

class User extends BaseModel {
	
	use SoftDeletingTrait;
	
	/**
	 * Fillables
	 * define which attributes are mass assignable (for security)
	 *
	 * @var array
	 */
	protected $fillable = array('firstname', 'name', 'email', 'password');
	
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
	 *	Find By Email
	 *
	 *	@param	object	$query
	 *	@param	string	$email
	 *
	 *	@return	object
	 */
	public function scopeEmail ($query, $email)
	{
		return $query->where ('email', $email);
	}
	
	
	/**
	 * Get user id
	 *
	 * @return	int
	 */
	public function getId ()
	{
		return (int) $this->id;
	}
	
	/**
	 * Get user full name
	 *
	 * @return	string
	 */
	public function getFullName ()
	{
		return $this->firstname . ' ' . $this->name;
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
	public function setName ($name)
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
	 * Get Accounts
	 * All accounts related to the user.
	 *
     * @param	$display
     * @return	array
     */
	public function getAccounts ($display)
	{
		# Get related users
		return $this->accounts->schema ($display);
	}

}
