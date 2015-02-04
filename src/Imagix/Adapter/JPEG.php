<?php

namespace Imagix\Adapter;

use Imagix\Exception;

/*
	JPEG file type
*/
class JPEG extends AbstractAdapter{

	/*
		Load image
		
		Parameters
			string $path
		
		Return
			resource, false
	*/
	protected function loadImage($path){
		return imagecreatefromjpeg($path);
	}

	/*
		Get image contents
		
		Parameters
			array $options
		
		Return
			string
	*/
	public function getContents(array $options=array()){
		$options['quality']=isset($options['quality'])?$options['quality']:80;
		ob_start();
		imagejpeg($this->resource,null,$options['quality']);
		return ob_get_clean();
	}

	/*
		Get file extension
	
		Return
			string
	*/
	public function getExtension(){
		return 'jpg';
	}

	/*
		Get file mimetype
		
		Return
			string
	*/
	public function getMimetype(){
		return 'image/jpeg';
	}
	
	/*
		Verify if the provided file is compatible
		
		Parameters
			string $path
		
		Return
			boolean
	*/
	static public function supports($path){
		if(!extension_loaded('exif')){
			throw new Exception("Cannot verify '$path' image type, Exif extension is not loaded");
		}
		return exif_imagetype($path)==IMAGETYPE_JPEG;
	}

}
