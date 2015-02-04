<?php

namespace Imagix\Effect;

/*
	Sepia effect
*/
class Sepia extends AbstractEffect{

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
		if(!imagefilter($resource,IMG_FILTER_GRAYSCALE)){
			throw new Exception("GRAYSCALE filter failed");
		}
		if(!imagefilter($resource,IMG_FILTER_COLORIZE,65,30,20)){
			throw new Exception("COLORIZE filter failed");
		}
		if(!imagefilter($resource,IMG_FILTER_CONTRAST,-7)){
			throw new Exception("CONTRAST filter failed");
		}
		return $resource;
	}

}
