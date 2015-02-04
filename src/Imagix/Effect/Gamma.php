<?php

namespace Imagix\Effect;

/*
	Gamma correction
*/
class Gamma extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource
			float $input	: input gamma factor
			float $output	: output gamma factor
		
		Return
			resource
	*/
	public function apply($resource){
		@list(,$input,$output)=func_get_args();
		$input=(float)$input;
		$output=(float)$output;
		if(!imagegammacorrect($resource,$input,$output)){
			throw new Exception("Gamma correction failed");
		}
		return $resource;
	}

}
