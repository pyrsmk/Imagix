<?php

namespace Imagix\Effect;

/*
	Interlace effect
*/
class Interlace extends Lines{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource
		
		Return
			resource
	*/
	public function apply($resource){
		return parent::apply($resource,parent::HORIZONTAL,2,1,0,0,0);
	}

}
