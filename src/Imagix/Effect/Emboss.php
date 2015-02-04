<?php

namespace Imagix\Effect;

/*
	Emboss effect
*/
class Emboss extends Matrix{

	/*
		integer MATRIX: matrix convolution method
		integer FILTER: EMBOSS filter method
	*/
	const MATRIX	= 0;
	const FILTER	= 1;

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $method		: method to use, MATRIX (default) or FILTER
		
		Return
			resource
	*/
	public function apply($resource){
		@list(,$method)=func_get_args();
		switch($method){
			case self::FILTER:
				if(!function_exists('imagefilter')){
					throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
				}
				if(!imagefilter($resource,IMG_FILTER_EMBOSS)){
					throw new Exception("EMBOSS filter failed");
				}
				return $resource;
			case self::MATRIX:
			default:
				return parent::apply($resource,array(-2,-1,0,-1,1,1,0,1,2));
		}
	}

}
