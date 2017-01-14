<?php

namespace Imagix\Effect;

/*
	Screen effect
	
	Resources
		http://www.tuxradar.com/practicalphp/11/2/18
*/
class Screen extends Lines{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource
		
		Return
			resource
	*/
	public function apply($resource){
		return parent::apply(
			parent::apply(
				$resource,
				parent::HORIZONTAL,
				2,1,0,0,0
			),
			parent::VERTICAL,
			2,1,0,0,0
		);
	}

}
