<?php

namespace Imagix\Effect;

/*
	Sharpen effect
*/
class Sharpen extends Matrix{

	/*
		integer MATRIX: convolution matrix method
		integer FILTER: MEAN_REMOVAL filter method
	*/
	const MATRIX = 0;
	const FILTER = 1;

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $method		: method to use, MATRIX (by default) or FILTER
		
		Return
			resource
	*/
	public function apply($resource){
		@list(,$method)=func_get_args();
		switch($method){
			case self::FILTER:
				if(!function_exists('imagefilter')){
					throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library, therefore you cannot use this graphic effect");
				}
				if(!imagefilter($resource,IMG_FILTER_MEAN_REMOVAL)){
					throw new Exception("MEAN_REMOVAL filter failed");
				}
				return $resource;
			case self::MATRIX:
			default:
				return parent::apply(func_get_arg(0),array(0,-1,0,-1,5,-1,0,-1,0));
		}
	}

}
