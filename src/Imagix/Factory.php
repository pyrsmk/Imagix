<?php

namespace Imagix;

/*
	Imagix factory
*/
class Factory{

	/*
		Instantiate the good object according to the provided image
		
		Return
			Imagix\Image
	*/
	static public function forge($path){
		// Prepare
		$excludes=array('AbstractAdapter.php','AdapterInterface.php');
		// Browse adapters
		foreach(lessdir(__DIR__.'/Adapter') as $file){
			if(in_array($file,$excludes)){
				continue;
			}
			$class='Imagix\Adapter\\'.pathinfo($file,PATHINFO_FILENAME);
			if($class::supports($path)){
				return new Image(new $class($path));
			}
		}
		// No adapter found
		throw new Exception("'$path' image file is not supported");
	}
	
}
