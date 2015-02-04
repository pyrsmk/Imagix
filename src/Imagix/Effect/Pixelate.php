<?php

namespace Imagix\Effect;

/*
	Pixelate an image
*/
class Pixelate extends AbstractEffect{

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			integer $block_size	: block size
			boolean $advanced	: advanced mode (true by default)

		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$block_size,$advanced)=func_get_args();
		$block_size=(int)$block_size;
		if($block_size<2){
			$block_size=2;
		}
		if($advanced===null){
			$advanced=true;
		}
		else{
			$advanced=(bool)$advanced;
		}
		// Pixelate
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		if(!imagefilter($resource,IMG_FILTER_PIXELATE,$block_size,$advanced)){
			throw new Exception("PIXELATE filter failed");
		}
		return $resource;
	}

}
