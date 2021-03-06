<?php

namespace Imagix\Effect;

/*
	Grayscale
*/
class Grayscale extends AbstractEffect{

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
		return $resource;
	}

}
