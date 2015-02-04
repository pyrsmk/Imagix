<?php

namespace Imagix\Effect;

/*
	Crop an image
*/
class Crop extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $x			: x offset
			integer $y			: y offset
			integer $width		: width
			integer $height		: height
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$x,$y,$width,$height)=func_get_args();
		$x=(int)$x;
		$y=(int)$y;
		$width=(int)$width;
		$height=(int)$height;
		// Get resolution
		$w_src=imagesx($resource);
		$h_src=imagesy($resource);
		if($w_src===false || $h_src===false){
			throw new Exception("An error was encountered while getting source image resolution");
		}
		// Verifications
		if(!$width || !$height){
			throw new Exception("Invalid image resolution provided");
		}
		if(($x+$width)>$w_src || ($y+$height)>$h_src){
			throw new Exception("Dimensions provided seems to be out of the image resolution");
		}
		// Create new image
		$image=$this->_createTrueColor($width,$height);
		// Cut image
		if(!imagecopy($image,$resource,0,0,$x,$y,$width,$height)){
			throw new Exception("Failed to copy image portion");
		}
		return $image;
	}

}
