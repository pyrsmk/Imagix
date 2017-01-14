<?php

namespace Imagix\Effect;

/*
	Draw lines
*/
class Lines extends Line{

	/*
		integer HORIZONTAL  : horizontal drawing
		integer VERTICAL    : vertical drawing
	*/
	const HORIZONTAL	= 0;
	const VERTICAL		= 1;

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $direction	: HORIZONTAL or VERTICAL
			integer $step		: step for drawing lines, greater than or equal to 2 (5 by default)
			integer $thickness	: line thickness
			string $color		: HTML color
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$direction,$step,$thickness,$color)=func_get_args();
		$step=(int)$step;
		$thickness=(int)$thickness;
		if($step<2){
			$step=2;
		}
		// Get resolution
		$width=imagesx($resource);
		$height=imagesy($resource);
		if($width===false || $height===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Apply effect
		switch($direction){
			case self::VERTICAL:
				$x=0;
				while(($x+=$step)<$width){
					parent::apply($resource,$x,0,$x,$height,$thickness,$color);
				}
				break;
			case self::HORIZONTAL:
			default:
				$y=0;
				while(($y+=$step)<$height){
					parent::apply($resource,0,$y,$width,$y,$thickness,$color);
				}
		}
		return $resource;
	}

}
