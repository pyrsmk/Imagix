<?php

namespace Imagix\Effect;

/*
	Add corners to an image
*/
class Corner extends Mask{

	/*
		integer ROUNDED     : rounded corners
		integer BEVELLED    : bevelled corners
		integer TRUNCATED   : truncated corners
	*/
	const ROUNDED       = 0;
	const BEVELLED      = 2;
	const TRUNCATED     = 3;

	/*
		integer ALL         : all corners
		integer TOPLEFT     : top/left corner
		integer TOPRIGHT    : top/right corner
		integer BOTTOMRIGHT : bottom/right corner
		integer BOTTOMLEFT  : bottom/left corner
	*/
	const ALL           = 0;
	const TOPLEFT       = 1;
	const TOPRIGHT      = 2;
	const BOTTOMRIGHT   = 3;
	const BOTTOMLEFT    = 4;

	/*
		Apply effects on an image

		Parameters
			resource $resource	: image resource
			integer $size		: corner size
			integer $type		: corner type
			integer $corners	: which corners to apply, either ALL, TOPLEFT, TOPRIGHT, BOTTOMRIGHT or BOTTOMLEFT

		Return
			resource
	*/
	public function apply($resource){
		// Format
		@list(,$size,$type,$corners)=func_get_args();
		$size=$size?(int)$size:10;
		$type=(int)$type;
		$corners=(int)$corners;
		// Normalize
		if(!$size){
			$size=10;
		}
		if(
			$corners!=self::ALL &&
			$corners!=self::TOPLEFT &&
			$corners!=self::TOPRIGHT &&
			$corners!=self::BOTTOMRIGHT &&
			$corners!=self::BOTTOMLEFT
		){
			$corners=self::ALL;
		}
		// Get resolution
		$width=imagesx($resource);
		$height=imagesy($resource);
		if($width===false || $height===false){
			throw new Exception("An error was encountered while getting image resolution");
		}
		// Create mask
		$corner=$this->_createTrueColor($size,$size);
		imageantialias($corner,true);
		$white=imagecolorallocate($corner,255,255,255);
		$gray=imagecolorallocate($corner,150,150,150);
		$black=imagecolorallocate($corner,0,0,0);
		imagefill($corner,0,0,$white);
		switch($type){
			case self::BEVELLED:
				imagefilledarc($corner,$size,$size,$size*2+2,$size*2+2,180,270,$gray,IMG_ARC_CHORD); // anti-aliasing
				imagefilledarc($corner,$size,$size,$size*2+1,$size*2+1,180,270,$black,IMG_ARC_CHORD);
				break;
			case self::TRUNCATED:
				break;
			case self::ROUNDED:
			default:
				imagefilledarc($corner,$size,$size,$size*2+2,$size*2+2,180,270,$gray,IMG_ARC_PIE); // anti-aliasing
				imagefilledarc($corner,$size,$size,$size*2+1,$size*2+1,180,270,$black,IMG_ARC_PIE);
		}
		// Prepare corners to apply
		if($corners==self::ALL || $corners==self::TOPLEFT)      $topleft=$corner;
		if($corners==self::ALL || $corners==self::TOPRIGHT)     $topright=imagerotate($corner,270,0);
		if($corners==self::ALL || $corners==self::BOTTOMRIGHT)  $bottomright=imagerotate($corner,180,0);
		if($corners==self::ALL || $corners==self::BOTTOMLEFT)   $bottomleft=imagerotate($corner,90,0);
		// Apply corners
		if(isset($topleft))		$resource=parent::apply($resource,$topleft,0);
		if(isset($topright))	$resource=parent::apply($resource,$topright,$width-$size);
		if(isset($bottomright))	$resource=parent::apply($resource,$bottomright,$width-$size,$height-$size);
		if(isset($bottomleft))	$resource=parent::apply($resource,$bottomleft,0,$height-$size);
		// Clean up
		@imagedestroy($topleft);
		@imagedestroy($topright);
		@imagedestroy($bottomright);
		@imagedestroy($bottomleft);
		return $resource;
	}

}
