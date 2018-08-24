<?php
namespace Cloudoki\OaStack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Cloudoki\OaStack\Collections\BaseCollection;

class BaseModel extends Model
{
	/**
	 *	Base Collection
	 *	Add a custom collection extension
	 *
	 *	@return Collection
	 */
	public function newCollection (array $models = array ())
	{
		return new BaseCollection ($models);
	}

	/**
	 * Id
	 * Get resource id
	 *
	 * @return	int
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 *	Scheme
	 *	Filter response, based on schema.json and display type
	 *
	 * @param $display
	 * @return object
	 * @throws ValidationException
	 */
	public function schema ($display)
	{
		$response = array();

		$rules = (array) self::getScheme ($this::type . '.json');

		# Validate
		if (!$display || !$rules)
		{
			throw new ValidationException ('Scheme mismatch or display parameter missing');
		}

		# Return id
		if ($display == 'id') return $this->getId ();

		# Evaluate schema
		foreach ($rules [$display] as $key => $funcpair) {
            $func = explode(':', $funcpair);
            
            $functionName = $func[0];
            $response[$key] = $this->$functionName (isset ($func[1]) ? $func[1] : null, isset ($func[2]) ? $func[2] : null);
        }
        
        return (object) $response;
	}

	/**
	 *	Scheme Update
	 *	Update model, based on schema.json
	 *
	 * @param $input
	 * @return mixed
	 * @throws ValidationException
	 */
	public function schemaUpdate ($input)
	{
		try
		{
			$schema = (array) self::getScheme ($this::type . '.json')->set->protected;
		}
		catch (Exception $e)
		{
			throw new ValidationException ('Update file not found or malformed');
		}

		# Evaluate schema
		foreach ($schema as $key => $func)

			if (isset ($input[$key]))

				$this::$func ($input[$key]);

		# Update - push could be used here in case of relational updates.
		return $this->save();
	}

	/**
	 * Get Seed Content
	 * Retreive content from schema seed file
	 *
	 * @param $filename
	 * @return mixed
	 * @throws ValidationException
	 */
	protected static function getScheme ($filename)
	{
		# Get channels'accounts_channels.json'
		$file = __DIR__ . '/schemes/' . strtolower ($filename);

		if (!file_exists ($file))

			throw new ValidationException ('Scheme file not found');

		else return json_decode (file_get_contents ($file));
	}

	/**
	 *	Get Constant
	 *	Get constant defined on model
	 *
	 *	@return const mixed
	 */
	public function getConst ($name)
	{
		$model = new \ReflectionClass ($this);

		return $model->getConstant($name);
	}

	/**
	 *	Get Meta
	 *	Get non indexable data from object
	 *
	 *	@return const mixed
	 */
	public function getMeta ($key)
	{
		# Check for existance
		if (!$this->meta) return null;

		# Convert if required
		if (!isset ($this->meta_json))

			$this->meta_json = json_decode ($this->meta, true);


		# Retrieve value from meta
		return isset ($this->meta_json[$key])?

			$this->meta_json[$key]:
			null;
	}

	/**
	 *	Set Meta
	 *	Set non indexable data on object
	 *	!Not Finished!
	 *
	 *	@return self
	 */
	public function setMeta ($key, $value = null)
	{
		# Convert if required
		if (!isset ($this->meta_json))

			$this->meta_json = json_decode ($this->meta?: "{}", true);

		# The scheme update function
		# should be updated for :-style $key parsing

		return $this;
	}

	/**
	 *	Parse Array
	 *	Insert dynamic object values in provided array
	 *	and return new array
	 *
	 *	@return array
	 */
	public function parseTemplateArray ($haystack, $replace)
	{
		$parsed = array ();

		# do some basic blade style string replace
		foreach ($haystack as $key=> $value)

			if (is_string ($value))

				$parsed [$key] = self::replaceHolder ($value, $replace);

			# Go deeper
			else if (is_object ($value) || is_array ($value))

				$parsed [$key] = $this->parseTemplateArray ($value, $replace);

			# Leave it
			else $parsed [$key] = $value;

		return $parsed;
	}

	/**
	 *	Replacement
	 *	Mustache style notation
	 *	includes laravel deep dotted nesting
	 *
	 *	{{...}}	replace with placeholder occurance
	 *	{{#..}}	evaluate as boolean true
	 *	{{^..}}	evaluate as boolean false
	 *	{{$..}}	evaluate as count
	 *
	 *	@return mixed
	 */
	public static function replaceHolder ($value, $replace)
	{
		# Regex replace
		return preg_replace_callback ('/({{\#|{{\^|{{\$|{{)(.+?)}}/', function ($matches) use ($replace)
		{
			# Look for deep nested replacement
			$result = (strpos ($matches[2], '.'))?

				array_get ($replace, $matches[2]):
				(isset ($replace [$matches [2]])? $replace [$matches [2]]: null);


			# Look for true conditional
			if ($matches[1] == "{{#")

				$result = $result? (bool) $result: null;

			# Look for false conditional
			else if ($matches[1] == "{{^")

				$result = !(bool) $result;

			# Look for count
			else if ($matches[1] == "{{\$")

				$result = count ($result);


			return $result;

		}, $value);
	}
}
