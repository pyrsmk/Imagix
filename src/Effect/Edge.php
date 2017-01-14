<?php

namespace Imagix\Effect;

/*
	Edge effect
*/
class Edge extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource : resource image
		
		Return
			resource
	*/
	public function apply($resource){
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		if(!imagefilter($resource,IMG_FILTER_EDGEDETECT)){
			throw new Exception("EDGEDETECT filter failed");
		}
		return $resource;
	}

}
