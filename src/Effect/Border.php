<?php

namespace Imagix\Effect;

/*
	Draw a border
*/
class Border extends Line{

	/*
		integer ALL     : draw all borders
		integer TOP     : draw top border
		integer RIGHT   : draw right border
		integer BOTTOM  : draw bottom border
		integer LEFT    : draw left border
	*/
	const ALL		= 0;
	const TOP		= 1;
	const RIGHT		= 2;
	const BOTTOM	= 3;
	const LEFT		= 4;
	
	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $thickness	: border size
			string $color		: HTML color
			integer $sides		: which sides to draw (ALL, TOP, RIGHT, BOTTOM or LEFT)
		
		Return
			resource
	*/
	public function apply($resource){
		// Get arguments
		@list(,$thickness,$color,$sides)=func_get_args();
		$thickness=(int)$thickness;
		if(!$color){
			$color='#000000';
		}
		$sides=(int)$sides;
		// Get resolution
		$width=imagesx($resource);
		$height=imagesy($resource);
		if($width===false || $height===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Define adjustment
		$z=$thickness/2;
		// Draw borders
		if($sides==self::ALL || $sides==self::TOP){
			parent::apply($resource,0,$z,$width,$z,$thickness,$color);
		}
		if($sides==self::ALL || $sides==self::RIGHT){
			parent::apply($resource,$width-$z,$z,$width-$z,$height,$thickness,$color);
		}
		if($sides==self::ALL || $sides==self::BOTTOM){
			parent::apply($resource,$width-$z,$height-$z,0,$height-$z,$thickness,$color);
		}
		if($sides==self::ALL || $sides==self::LEFT){
			parent::apply($resource,$z,$height,$z,0,$thickness,$color);
		}
		return $resource;
	}

}
