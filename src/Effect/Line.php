<?php

namespace Imagix\Effect;

/*
	Draw one line
*/
class Line extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $x1			: x coord of first point
			integer $y1			: y coord of first point
			integer $x2			: x coord of second point
			integer $y2			: y coord fo second point
			integer $thickness	: line thickness
			string $color		: HTML color
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$x1,$y1,$x2,$y2,$thickness,$color)=func_get_args();
		$x1=(int)$x1;
		$y1=(int)$y1;
		$x2=(int)$x2;
		$y2=(int)$y2;
		$thickness=(int)$thickness;
		if(!$color){
			$color='#000000';
		}
		$rgb=html2rgb($color);
		if($thickness<1){
			$thickness=1;
		}
		// Draw line
		if(!imagesetthickness($resource,$thickness)){
			throw new Exception("Thickness line changing failed");
		}
		if(!imageline($resource,$x1,$y1,$x2,$y2,imagecolorallocate($resource,$rgb[0],$rgb[1],$rgb[2]))){
			throw new Exception("Line drawing failed");
		}
		return $resource;
	}

}
