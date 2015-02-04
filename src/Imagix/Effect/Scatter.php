<?php

namespace Imagix\Effect;

/*
	Scattering
	
	Resources
		http://www.tuxradar.com/practicalphp/11/2/23
*/
class Scatter extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $level		: level
		
		Return
			resource
	*/
	public function apply($resource){
		// Format
		@list(,$level)=func_get_args();
		$level=abs((int)$level);
		if(!$level){
			$level=1;
		}
		// Get resolution
		$width=imagesx($resource);
		$height=imagesy($resource);
		if($width===false || $height===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Loop over all pixels
		$x=0;
		do{
			$y=0;
			do{
				// Generate a position
				$newx=$x+rand(-$level,$level);
				$newy=$y+rand(-$level,$level);
				// Verify that we're not out of bounds
				if($newx>=0 && $newx<$width && $newy>=0 && $newy<$height){
					// Interchange both pixels
					$color=imagecolorat($resource,$x,$y);
					imagesetpixel($resource,$x,$y,imagecolorat($resource,$newx,$newy));
					imagesetpixel($resource,$newx,$newy,$color);
				}
			}
			while(++$y<$height);
		}
		while(++$x<$width);
		return $resource;
	}

}
