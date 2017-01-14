<?php

namespace Imagix\Effect;

/*
	Brightness adjustment
*/
class Brightness extends AbstractEffect{

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			integer				: level

		Return
			resource
	*/
	public function apply($resource){
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		// Format
		@list(,$level)=func_get_args();
		$level=(int)$level;
		if($level<-255) $level=-255;
		if($level>255)  $level=255;
		// Apply effect
		if(!imagefilter($resource,IMG_FILTER_BRIGHTNESS,$level)){
			throw new Exception("BRIGHTNESS filter failed");
		}
		return $resource;
	}

}
