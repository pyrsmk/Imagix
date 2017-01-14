<?php

namespace Imagix\Effect;

/*
	Rotate an image
*/
class Rotate extends AbstractEffect{

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			float $angle		: rotation angle
			string $color		: HTML color

		Return
			resource
	*/
	public function apply($resource){
		// Verify support
		if(!function_exists('imagerotate')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		// Get arguments
		@list(,$angle,$color)=func_get_args();
		$angle=(float)$angle;
		if(!$color){
			$color='#FFFFFF';
		}
		$rgb=html2rgb($color);
		// Apply effect
		$resource=imagerotate($resource,$angle,imagecolorallocate($resource,$rgb[0],$rgb[1],$rgb[2]));
		if(!$resource){
			throw new Exception("Image rotation failed");
		}
		return $resource;
	}

}
