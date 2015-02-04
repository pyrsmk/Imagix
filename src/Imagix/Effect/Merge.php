<?php

namespace Imagix\Effect;

/*
	Merge two images
*/
class Merge extends AbstractEffect{

	/*
		integer NORMAL      : normal merging
		integer GRAYSCALE   : grayscale merging (to keep hue)
	*/
	const NORMAL    = 0;
	const GRAYSCALE = 1;

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			resource $image		: resource to merge
			integer $method		: method to use, NORMAL (default) or GRAYSCALE
			integer $x1			: x coord where image will be merged
			integer $y1			: y coord where image will be merged
			integer $x2			: x coord for the part to merge
			integer $y2			: y coord for the part to merge
			integer $src_w		: width of the image part to merge
			integer $src_h		: height of the image part to merge
			integer $pct		: merging indice

		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$image,$method,$x1,$y1,$x2,$y2,$src_w,$src_h,$pct)=func_get_args();
		$x1=(int)$x1;
		$y1=(int)$y1;
		$x2=(int)$x2;
		$y2=(int)$y2;
		$src_w=(int)$src_w;
		$src_h=(int)$src_h;
		$pct=(int)$pct;
		// Verify
		if($image instanceof Imagix\AbstractImage){
			$image=$image->getResource();
		}
		elseif(!is_resource($image)){
			throw new Exception("The 'image' parameter must be a valid GD resource or a Lumy\Image\AbstractImage child object");
		}
		// Normalize
		if(!$src_w)         $src_w=imagesx($image);
		if(!$src_h)         $src_h=imagesy($image);
		if($pct===null)     $pct=50;
		elseif($pct<0)      $pct=0;
		elseif($pct>100)    $pct=100;
		// Merge images
		switch($method){
			case self::GRAYSCALE:
				imagecopymergegray($resource,$image,$x1,$y1,$x2,$y2,$src_w,$src_h,$pct);
				break;
			case self::NORMAL:
			default:
				imagecopymerge($resource,$image,$x1,$y1,$x2,$y2,$src_w,$src_h,$pct);
		}
		return $resource;
	}

}
