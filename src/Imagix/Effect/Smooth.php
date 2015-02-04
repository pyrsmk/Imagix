<?php

namespace Imagix\Effect;

/*
	Smooth effect
*/
class Smooth extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $level		: level
		
		Return
			resource
	*/
	public function apply($resource){
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library, therefore you cannot use this graphic effect");
		}
		@list(,$level)=func_get_args();
		if(!imagefilter($resource,IMG_FILTER_SMOOTH,(int)$level)){
			throw new Exception("SMOOTH filter failed");
		}
		return $resource;
	}

}
