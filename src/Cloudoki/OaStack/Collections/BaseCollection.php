<?php

namespace Cloudoki\OaStack\Collections;

use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
/**
 * Base Collection
 * The Base Collection extends the rich Eloquent Collection
 * with API-centric extra's
 */

class BaseCollection extends Collection
{

	/**
	 *	Schema
	 *	Filter response, based on schema.json
	 *
	 * @param	$display
	 * @return	array
	 * @throws	MissingMandatoryParametersException
	 */
	public function schema ($display)
	{

		$response = [];

		# Validate
		if (!$display)

			throw new MissingMandatoryParametersException ('Display parameter missing'); # MissingParameterException ('Display parameter missing');

		# Return id
		if ($display == 'id')

			return $this->lists ('id');

		# Evaluate schema
		foreach ($this->all () as $model)

			$response[] = $model->schema ($display);

		return $response;
	}


	/**
	 *	Update
	 *	Update all collection members
	 *
	 *	@param	array		$data
	 *	@return	Collection
	 */
	public function update ($data)
	{
		if (!$this->isEmpty ())

			(new $this->model)
				->whereIn ('id', $this->lists ('id'))
				->update  ($data);


		return $this;
	}

}
