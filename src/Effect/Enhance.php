<?php

namespace Imagix\Effect;

/*
	Enhance an image
	
	Thanks
		fabien.snauwaert@gmail.com
*/
class Enhance extends Matrix{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource
		
		Return
			resource
	*/
	public function apply($resource){
		return parent::apply($resource,array(0,-2,0,-2,20,-2,0,-2,0));
	}

}
