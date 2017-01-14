<?php

namespace Imagix\Effect;

/*
	Contrast adjustment
*/
class Blur extends AbstractEffect{

	/*
		integer SELECTIVE   : SELECTIVE_BLUR filter
		integer GAUSSIAN    : GAUSSIAN_BLUR filter
	*/
	const SELECTIVE = 0;
	const GAUSSIAN  = 1;

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			integer $method		: method to use, GAUSSIAN or SELECTIVE (default)

		Return
			resource
	*/
	public function apply($resource){
		// Verify support
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		// Extract arguments
		@list(,$method)=func_get_args();
		// Apply effect
		switch($method){
			case self::GAUSSIAN:
				if(!imagefilter($resource,IMG_FILTER_GAUSSIAN_BLUR)){
					throw new Exception("GAUSSIAN_BLUR filter failed");
				}
				break;
			case self::SELECTIVE:
			default:
				if(!imagefilter($resource,IMG_FILTER_SELECTIVE_BLUR)){
					throw new Exception("SELECTIVE_BLUR filter failed");
				}
		}
		return $resource;
	}

}
