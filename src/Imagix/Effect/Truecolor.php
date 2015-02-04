<?php

namespace Imagix\Effect;

/*
	Convert an image to true colors
	
	Thanks
		will@fnatic.com
*/
class Truecolor extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
		
		Return
			resource
	*/
	public function apply($resource){
		// Get resolution
		$width=imagesx($resource);
		$height=imagesy($resource);
		if($width===false || $height===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Image conversion
		$new=imagecreatetruecolor($width,$height);
		if(!imagecopy($new,$resource,0,0,0,0,$width,$height)){
			throw new Exception("An error was encountered while copying image");
		}
		return $new;
	}

}
