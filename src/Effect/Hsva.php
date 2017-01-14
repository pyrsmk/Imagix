<?php

namespace Imagix\Effect;

/*
	Modify hue, saturation, value and opacity

	Thanks
		mail@kavisiegel.com
*/
class Hsva extends AbstractEffect{

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			integer $h			: hue
			integer $s			: saturation
			integer $v			: value
			integer $a			: alpha

		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$h,$s,$v,$a)=func_get_args();
		$h=(int)$h;
		$s=(int)$s;
		$v=(int)$v;
		$a=(int)$a;
		// Convert
		list($r,$g,$b)=hsv2rgb($h,$s,$v);
		// Normalize
		if($a<0)        $a=0;
		elseif($a>100)  $a=100;
		if($v<0)        $v=0;
		elseif($v>100)  $v=100;
		$a=(100-$a)*1.27;
		$v=($v*2-100)*2.55;
		// Compute hue ratio
		$delta=($r+$g+$b);
		if($delta!=0){
			$ratio1=$r/$delta;
			$ratio2=$g/$delta;
			$ratio3=$b/$delta;
		}
		// récupération de la résolution
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
				list($r,$g,$b)=$this->_getColorAt($resource,$x,$y);
				// Define new color
				$new_r=$r*$ratio1+$g*$ratio2+$b*$ratio3+$v;
				$new_g=$r*$ratio3+$g*$ratio1+$b*$ratio2+$v;
				$new_b=$r*$ratio2+$g*$ratio3+$b*$ratio1+$v;
				// Format
				if($new_r<0)        $new_r=0;
				elseif($new_r>255)  $new_r=255;
				if($new_g<0)        $new_g=0;
				elseif($new_g>255)  $new_g=255;
				if($new_b<0)        $new_b=0;
				elseif($new_b>255)  $new_b=255;
				// Define pixel
				imagesetpixel($resource,$x,$y,imagecolorallocatealpha($resource,$new_r,$new_g,$new_b,$a));
			}
			while(++$y<$height);
		}
		while(++$x<$width);
		return $resource;
	}

}
