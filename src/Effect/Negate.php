<?php

namespace Imagix\Effect;

/*
	Negative effect
*/
class Negate extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource : image resource
		
		Return
			resource
	*/
	public function apply($resource){
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		if(!imagefilter($resource,IMG_FILTER_NEGATE)){
			throw new Exception("NEGATE filter failed");
		}
		return $resource;
	}

}
