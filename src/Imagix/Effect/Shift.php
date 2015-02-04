<?php

namespace Imagix\Effect;

/*
	Shift image
*/
class Shift extends Matrix{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource
		
		Return
			resource
	*/
	public function apply($resource){
		return parent::apply($resource,array(1,0,0,0,0,0,0,0,0));
	}

}
