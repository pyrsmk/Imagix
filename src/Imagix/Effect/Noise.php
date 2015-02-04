<?php

namespace Imagix\Effect;

/*
    Add noise
    
    Resources
        http://www.tuxradar.com/practicalphp/11/2/22
*/
class Noise extends AbstractEffect{

    /*
        Apply effects on an image
        
        Parameters
            resource $resource	: image resource
            integer $level		: level
        
        Return
            resource
    */
	public function apply($resource){
		// Extract arguments
		@list(,$level)=func_get_args();
		$level=abs((int)$level);
		if(!$level){
		    $level=5;
		}
		// Get resolution
		$width=imagesx($resource);
		$height=imagesy($resource);
		if(!$width || !$height){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Apply effect
		$x=0;
		do{
			$y=0;
			do{
				// Get current pixel color
				list($r,$g,$b,$a)=$this->_getColorAt($resource,$x,$y);
				// Generate noise
				$z=rand(-$level,$level);
				// Define color
				$r+=$z;
				$g+=$z;
				$b+=$z;
				if($r<0)		$r=0;
				elseif($r>255)	$r=255;
				if($g<0)		$g=0;
				elseif($g>255)	$g=255;
				if($b<0)		$b=0;
				elseif($b>255)	$b=255;
				// Define new pixel
				imagesetpixel($resource,$x,$y,imagecolorallocatealpha($resource,$r,$g,$b,$a));
			}
			while(++$y<$height);
		}
		while(++$x<$width);
		return $resource;
	}

}
