<?php

namespace Imagix\Effect;

/*
	Apply a mask
*/
class Mask extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			resource $mask		: mask resource
			integer $xinit		: initial x coord in source image
			integer $yinit		: initial y coord in source image
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$mask,$xinit,$yinit)=func_get_args();
		if(is_subclass_of($mask,'Imagix\AbstractImage')){
			$mask=$mask->getResource();
		}
		elseif(!is_resource($mask)){
			throw new Exception("The 'mask' parameter must be a valid GD resource or a Lumy_File_Image child object");
		}
		// Prepare
		$w_mask=imagesx($mask);
		$h_mask=imagesy($mask);
		if($w_mask===false || $h_mask===false){
			throw new Exception("An error was encountered while getting mask image resolution");
		}
		$width=imagesx($resource);
		$height=imagesy($resource);
		if($width===false || $height===false){
			throw new Exception("An error was encountered while getting source image resolution");
		}
		$xinit=(int)$xinit;
		$yinit=(int)$yinit;
		if($xinit<0)				$xinit=0;
		if($xinit>$width-$w_mask)	$xinit=$width-$w_mask;
		if($yinit<0)				$yinit=0;
		if($yinit>$height-$h_mask)	$yinit=$height-$h_mask;
		// Create new image
		$image=$this->_createTrueColor($width,$height);
		if(!imagecopy($image,$resource,0,0,0,0,$width,$height)){
			throw new Exception("Cannot copy image");
		}
		// Modify colors
		$x=$xinit;
		do{
			$y=$yinit;
			do{
				// Get pixel color from source image
				$rgba_src=$this->_getColorAt($image,$x,$y);
				// Get pixel color from mask image
				$rgba_mask=$this->_getColorAt($mask,$x-$xinit,$y-$yinit);
				// Generate alpha
				if($rgba_mask[0]==$rgba_mask[1] && $rgba_mask[1]==$rgba_mask[2]){
					$alpha=floor($rgba_mask[0]/2)+$rgba_src[3];
					if($alpha>127) $alpha=127;
				}
				else{
					throw new Exception("Mask image must be in grayscale");
				}
				// Define new pixel
				$color=imagecolorallocatealpha($image,$rgba_src[0],$rgba_src[1],$rgba_src[2],$alpha);
				if($color===false){
					throw new Exception("Cannot allocate color");
				}
				if(!imagesetpixel($image,$x,$y,$color)){
					throw new Exception("Cannot set pixel");
				}
			}
			while(++$y<$h_mask+$yinit);
		}
		while(++$x<$w_mask+$xinit);
		return $image;
	}

}
