<?php

namespace Imagix\Effect;

/*
	Resize an image
*/
class Resize extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $width		: new width
			integer $height		: new height
			boolean $keep_ratio	: true to keep ratio (true by default)
		
		Return
			resource
	*/
	public function apply($resource){
		// Format
		@list(,$width,$height,$keep_ratio)=func_get_args();
		// Get original resolution
		$w_src=imagesx($resource);
		$h_src=imagesy($resource);
		if($w_src===false || $h_src===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Percent resize
		if(substr((string)$width,-1)=='%'){
			$percent=(float)substr($width,0,-1)/100;
			$width=round(imagesx($resource)*$percent);
			$height=round(imagesy($resource)*$percent);
		}
		// Manual resize
		else{
			$width=(int)$width;
			$height=(int)$height;
			if($keep_ratio===null){
				$keep_ratio=true;
			}
			else{
				$keep_ratio=(bool)$keep_ratio;
			}
			if($width<1){
				$width=1;
			}
			if($height<1){
				$height=1;
			}
			// Adapt resolution
			if($keep_ratio){
				if(($w_src/$width)>($h_src/$height)){
					$height=round(($width/$w_src)*$h_src);
				}
				else{
					$width=round(($height/$h_src)*$w_src);
				}
			}
		}
		// Create new image
		$image=$this->_createTrueColor($width,$height);
		// Resize
		if(!imagecopyresampled($image,$resource,0,0,0,0,$width,$height,$w_src,$h_src)){
			throw new Exception("Failed to resample image");
		}
		return $image;
	}

}
