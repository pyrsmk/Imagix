<?php

namespace Imagix\Effect;

/*
	imageconvolution() wrapper
		
	Thanks
		fabien.snauwaert@gmail.com
*/
class Matrix extends AbstractEffect{

	/*
		Apply effects on an image
		
		Parameters
			resource $resource	: image resource
			array $matrix		: convolution matrix
			integer $offset		: color position
		
		Return
			resource
	*/
	public function apply($resource){
		// Extract arguments
		@list(,$matrix,$offset)=func_get_args();
		$matrix=(array)$matrix;
		$offset=(int)$offset;
		// Verify matrix
		if(count($matrix)!=9){
			throw new Exception("The array parameter is a 3x3 matrix and must so contain 9 rows");
		}
		// Normalization
		$matrix=array(
			array($matrix[0],$matrix[1],$matrix[2]),
			array($matrix[3],$matrix[4],$matrix[5]),
			array($matrix[6],$matrix[7],$matrix[8])
		);
		// Compute normalization divisor
		$div=array_sum($matrix[0])+array_sum($matrix[1])+array_sum($matrix[2]);
		// Apply effect
		if(!imageconvolution($resource,$matrix,$div,$offset)){
			throw new Exception("Image convolution failed");
		}
		return $resource;
	}

}
