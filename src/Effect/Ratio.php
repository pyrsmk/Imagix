<?php

namespace Imagix\Effect;

/*
	Chop an image by ratio
*/
class Ratio extends Crop{

	/*
		integer CENTERED    : center image
		integer LEFT        : align to the left
		integer RIGHT       : align to the right
		integer TOP         : align to the top
		integer BOTTOM      : align to the bottom
	*/
	const CENTERED	= 0;
	const LEFT		= 1;
	const RIGHT		= 2;
	const TOP		= 3;
	const BOTTOM	= 4;

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: resource image
			float $w_ratio		: width ratio
			float $h_ratio		: height ratio
			integer $position	: rectangle copy position
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$w_ratio,$h_ratio,$position)=func_get_args();
		$w_ratio=(float)$w_ratio;
		$h_ratio=(float)$h_ratio;
		if($w_ratio<=0 or $h_ratio<=0){
			throw new Exception("Ratio cannot be null or negative");
		}
		// Get resolution
		$w_src=imagesx($resource);
		$h_src=imagesy($resource);
		if($w_src===false or $h_src===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Compute basic chop dimensions
		$w_tmp=round(($h_src/$h_ratio)*$w_ratio);
		$h_tmp=round(($w_src/$w_ratio)*$h_ratio);
		if($w_tmp>$h_tmp){
			$width=$w_src;
			$height=$h_tmp;
		}
		else{
			$width=$w_tmp;
			$height=$h_src;
		}
		// Compute position
		switch($position){
			case self::LEFT:
				$x=0;
				if($w_ratio<$h_ratio)		$y=0;
				elseif($w_ratio>$h_ratio)	$y=round(($h_src-$height)/2);
				else						$y=round(($h_src-$height)/2);
				break;
			case self::RIGHT:
				$x=$w_src-$width;
				if($w_ratio<$h_ratio)		$y=0;
				elseif($w_ratio>$h_ratio)	$y=round(($h_src-$height)/2);
				else						$y=round(($h_src-$height)/2);
				break;
			case self::TOP:
				if($w_ratio<$h_ratio)		$x=round(($w_src-$width)/2);
				elseif($w_ratio>$h_ratio)	$x=0;
				else						$x=round(($w_src-$width)/2);
				$y=0;
				break;
			case self::BOTTOM:
				if($w_ratio<$h_ratio)		$x=round(($w_src-$width)/2);
				elseif($w_ratio>$h_ratio)	$x=0;
				else						$x=round(($w_src-$width)/2);
				$y=$h_src-$height;
				break;
			case self::CENTERED:
			default:
				if($w_ratio<$h_ratio){
					$x=round(($w_src-$width)/2);
					$y=0;
				}
				elseif($w_ratio>$h_ratio){
					$x=0;
					$y=round(($h_src-$height)/2);
				}
				else{
					$x=round(($w_src-$width)/2);
					$y=round(($h_src-$height)/2);
				}
		}
		// Chop image
		return parent::apply($resource,$x,$y,$width,$height);
	}

}
