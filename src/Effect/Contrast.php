<?php

namespace Imagix\Effect;

/*
	Contrast adjustment
*/
class Contrast extends AbstractEffect{

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
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		@list(,$level)=func_get_args();
		if(!imagefilter($resource,IMG_FILTER_CONTRAST,(int)$level)){
			throw new Exception("CONTRAST filter failed");
		}
		return $resource;
	}

}
