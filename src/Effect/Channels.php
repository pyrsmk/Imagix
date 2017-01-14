<?php

namespace Imagix\Effect;

/*
	Addition colors
	
	Resources
		http://www.phpied.com/image-fun/
*/
class Channels extends AbstractEffect{

	/*
		integer NONE        : does nothing
		integer RED         : inject red channel
		integer GREEN       : inject green channel
		integer BLUE        : inject blue channel
		integer MINIMIZE    : switch channel to 0
		integer MAXIMIZE    : switch channel to 255
	*/
	const NONE		= 0;
	const RED		= 1;
	const GREEN		= 2;
	const BLUE		= 3;
	const MINIMIZE	= 4;
	const MAXIMIZE	= 5;

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			integer $r			: constant for red channel (NONE, RED, GREEN, BLUE, MINIMIZE or MAXIMIZE)
			integer $g			: constant for green channel (NONE, RED, GREEN, BLUE, MINIMIZE or MAXIMIZE)
			integer $b			: constant for blue channel (NONE, RED, GREEN, BLUE, MINIMIZE or MAXIMIZE)
		
		Return
			resource
	*/
	public function apply($resource){
		// Verify channels
		@list(,$r,$g,$b)=func_get_args();
		$channels=array($r,$g,$b);
		foreach($channels as $channel){
			if(
				$channel!=self::NONE and
				$channel!=self::RED and
				$channel!=self::GREEN and
				$channel!=self::BLUE and
				$channel!=self::MINIMIZE and
				$channel!=self::MAXIMIZE
			){
				throw new Exception("Undefined constant provided");
			}
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
				// Convert channels
				$new_channels=array();
				switch($channels[0]){
					case self::RED:			$new_channels['r']=$r; break;
					case self::GREEN:		$new_channels['r']=$g; break;
					case self::BLUE:		$new_channels['r']=$b; break;
					case self::MINIMIZE:	$new_channels['r']=0; break;
					case self::MAXIMIZE:	$new_channels['r']=255; break;
					case self::NONE:
					default:
						$new_channels['r']=$r;
				}
				switch($channels[1]){
					case self::RED:			$new_channels['g']=$r; break;
					case self::GREEN:		$new_channels['g']=$g; break;
					case self::BLUE:		$new_channels['g']=$b; break;
					case self::MINIMIZE:	$new_channels['g']=0; break;
					case self::MAXIMIZE:	$new_channels['g']=255; break;
					case self::NONE:
					default:
						$new_channels['g']=$g;
				}
				switch($channels[2]){
					case self::RED:			$new_channels['b']=$r; break;
					case self::GREEN:		$new_channels['b']=$g; break;
					case self::BLUE:		$new_channels['b']=$b; break;
					case self::MINIMIZE:	$new_channels['b']=0; break;
					case self::MAXIMIZE:	$new_channels['b']=255; break;
					case self::NONE:
					default:
						$new_channels['b']=$b;
				}
				// Define new pixel
				imagesetpixel($resource,$x,$y,imagecolorallocatealpha($resource,$new_channels['r'],$new_channels['g'],$new_channels['b'],$a));
			}
			while(++$y<$height);
		}
		while(++$x<$width);
		return $resource;
	}

}
