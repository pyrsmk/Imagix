<?php

namespace Imagix\Effect;

/*
	Duotone effect
	
	Resources
		http://www.tuxradar.com/practicalphp/11/2/21
*/
class Duotone extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $rplus		: red addition
			integer $bplus		: blue addition
			integer $gplus		: green addition
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$rplus,$gplus,$bplus)=func_get_args();
		$rplus=(int)$rplus;
		$gplus=(int)$gplus;
		$bplus=(int)$bplus;
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
				// Define new color
				$b=$r+$bplus;
				$g=$r+$gplus;
				$r+=$rplus;
				// Format
				if($r<0)		$r=0;
				elseif($r>255)	$r=255;
				if($g<0)		$g=0;
				elseif($g>255)	$g=255;
				if($b<0)		$b=0;
				elseif($b>255)	$b=255;
				// Define pixel
				imagesetpixel($resource,$x,$y,imagecolorallocatealpha($resource,$r,$g,$b,$a));
			}
			while(++$y<$height);
		}
		while(++$x<$width);
		return $resource;
	}

}
