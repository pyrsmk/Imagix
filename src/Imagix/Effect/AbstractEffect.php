<?php

namespace Imagix\Effect;

/*
    Abstract image effect class
    
    Author
        Aurélien Delogu (dev@dreamysource.fr)

    PHP dependencies
        GD
*/
abstract class AbstractEffect{

    /*
        Apply effects on an image
        
        Parameters
            resource $resource
        
        Return
            resource
    */
	abstract public function apply($resource);

    /*
        Create an empty image
        
        Parameters
            integer $width
            integer $height
        
        Return
            resource
    */
	final protected function _createTrueColor($width,$height){
	    // Format
	    $width=(int)$width;
	    $height=(int)$height;
		// Create image
		$resource=imagecreatetruecolor($width,$height);
		if(!$resource){
			throw new Exception("Failed to create new image");
		}
		// Set alpha channel
		imagealphablending($resource,false);
		$color=imagecolorallocatealpha($resource,0,0,0,127);
		imagecolortransparent($resource,$color);
		imagesavealpha($resource,true);
		return $resource;
	}

    /*
        Get a color from a pixel
        
        Parameters
            resource $resource
            integer $x
            integer $y
        
        Return
            array
    */
	final protected function _getColorAt($resource,$x,$y){
		$color=imagecolorat($resource,(int)$x,(int)$y);
		if($color===false){
			throw new Exception("Cannot get color");
		}
		if(imagecolorstotal($resource)){
			$rgba=imagecolorsforindex($resource,$color);
			if(!is_array($rgba)){
				throw new Exception("Cannot get colors for specified index");
			}
			return array($rgba['red'],$rgba['green'],$rgba['blue'],$rgba['alpha']);
		}
		else{
			return array(
				($color>>16)&0xFF,
				($color>>8)&0xFF,
				$color&0xFF,
				($color&0x7F000000)>>24
			);
		}
	}

}
