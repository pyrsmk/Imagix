<?php

namespace Imagix\Effect;

/*
	Add colors
*/
class Addition extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			string $color		: HTML color
			integer $opacity	: opacity, from 0 to 100
		
		Return
			resource
	*/
	public function apply($resource){
		// Verify support
		if(!function_exists('imagefilter')){
			throw new Exception("It seems your PHP version is not compiled with the bundled version of the GD library");
		}
		// Extract arguments
		@list(,$color,$opacity)=func_get_args();
		$rgb=html2rgb($color);
		// Normalize
		if($opacity===null)		$opacity=100;
		elseif($opacity<0)		$opacity=0;
		elseif($opacity>100)	$opacity=100;
		$a=(100-$opacity)*1.27;
		// Apply effect
		if(!imagefilter($resource,IMG_FILTER_COLORIZE,$rgb[0],$rgb[1],$rgb[2],$a)){
			throw new Exception("COLORIZE filter failed");
		}
		return $resource;
	}

}
