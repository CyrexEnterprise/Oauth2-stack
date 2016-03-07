<?php

namespace Cloudoki\OaStack\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;


class BaseController extends Controller
{
	/**
	 * Default schema
	 */
	const display = 'basic';

	/**
	 * Default validation rules
	 */
	protected $baseValidationRules = [
		'display'=> ''
	];

	/**
	 *  Request object
	 */
	var $request;


	/**
	 * BaseController construct
	 * MQ preps
	 */
	public function __construct (Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Provide all required parameters to Input
	 * Returns all input attibutes in array
	 *
	 * @return array
	 */
	protected function prepInput ($attr)
	{
		// Add display fallback
		$attr['display'] = $this->request->input ('display', self::display);

		return array_merge ($this->request->all(), $attr);
	}

	/**
	 * Validate Input
	 * Returns Laravel Validator object
	 *
	 * @throws Exception
	 */
	public function validate ($input, $rules = [])
	{
		// Add path attributes
		$input = $this->prepInput ($input);


		// Perform validation
		$validator = Validator::make ($input, $rules);


		// Check if the validator failed
		if ($validator->fails ())

			throw new ValidationException ( $validator );

		// return all input
		return $input;
	}

	 /**
     * Dispatch
     * The basic controller action between API and Worker
     *
     * @return mixed response
     */
	public static function jobdispatch($job, $jobload, $direct = false)
	{
		# Add general data
		$jobload->access_token = config ('app.access_token', null);

		# Response
		$response = app()->frontqueue->request($job, $jobload);
		
		if (isset ($response->error)) 
			
			return response ($response->error, $response->code);

		# Frontqueue call
		return $direct? 
			
			$response: 
			response()->json ($response);
	}


	/**
	 *  REST Dispatch
	 *  Jobdispatch extension with validation
	 *
	 *  @return Job response
	 */
	public function restDispatch ($method, $controller, $input = [], $rules = [])
	{
		# Extend rules
		$rules = array_merge ($this->baseValidationRules, $rules);

		# Validation
		$payload = array_intersect_key ($this->validate ($input, $rules), $rules);

		# Request Foreground Job
		$response = self::jobdispatch ('controllerDispatch', (object) ['action'=> $method, 'controller'=>  $controller, 'payload'=> (object) $payload], true);
		
		return is_string ($response)? 
		
			json_decode ($response): 
			(object) $response;
	}

	/**
	 * Sync shell
	 * Should be replaced by proper classes
	 *
	 *  Execute php job
	 *  The job is handled in sync mode
	 */

	protected static function doExec ($job, $jobload)
	{
		exec ("php -f '" . env ('WORKER_PATH', '..') . "/" . $job . ".php' sync '" . $jobload . "'", $output);

		return implode ("\n", $output);
	}


}

