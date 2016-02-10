<?php

namespace Cloudoki\OaStack;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Cloudoki\InvalidParameterException;

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

            throw new \Cloudoki\InvalidParameterException( 'Parameters validation failed!', $validator->messages()->all ());

        // return all input
        return $input;
    }

    /**
     * Dispatch
     * The basic controller action between API and Worker
     *
     * @return mixed response
     */
     public static function jobdispatch($job, $jobload)
     {
         // mock respons
         // return response()->json ([$job, $jobload]);

         // Sync hell
         return self::doExec ($job, json_encode ($jobload));

         /*global $app;

         // Add general data
         $jobload->open = round(microtime(true), 3);
         $jobload->access_token = Input::get('access_token');

         return $app->jobserver->request($job, $jobload);*/
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
        return self::jobdispatch ( 'controllerDispatch', (object)
        [
            'action'=>      $method,
            'controller'=>  $controller,
            'payload'=>     $payload
        ]);
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

