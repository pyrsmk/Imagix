<?php

namespace Imagix\Adapter;

use Imagix\Exception;

/*
	GIF file type
*/
class GIF extends AbstractAdapter{

	/*
		Load image
		
		Parameters
			string $path
		
		Return
			resource, false
	*/
	protected function loadImage($path){
		return imagecreatefromgif($path);
	}

	/*
		Get image contents
		
		Parameters
			array $options
		
		Return
			string
	*/
	public function getContents(array $options=array()){
		ob_start();
		imagegif($this->resource);
		return ob_get_clean();
	}

	/*
		Get file extension
	
		Return
			string
	*/
	public function getExtension(){
		return 'gif';
	}

	/*
		Get file mimetype
		
		Return
			string
	*/
	public function getMimetype(){
		return 'image/gif';
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
		return exif_imagetype($path)==IMAGETYPE_GIF;
	}

}
