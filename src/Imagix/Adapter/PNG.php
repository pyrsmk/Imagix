<?php

namespace Imagix\Adapter;

use Imagix\Exception;

/*
	PNG file type
*/
class PNG extends AbstractAdapter{

	/*
		Load image
		
		Parameters
			string $path
		
		Return
			resource, false
	*/
	protected function loadImage($path){
		$image=imagecreatefrompng($path);
		imagesavealpha($image,true);
		return $image;
	}

	/*
		Get image contents
		
		Parameters
			array $options
		
		Return
			string
	*/
	public function getContents(array $options=array()){
		$options['quality']=isset($options['quality'])?$options['quality']:9;
		$options['filters']=isset($options['filters'])?$options['filters']:PNG_NO_FILTER;
		ob_start();
		imagepng($this->resource,null,$options['quality'],$options['filters']);
		return ob_get_clean();
	}

	/*
		Get file extension
	
		Return
			string
	*/
	public function getExtension(){
		return 'png';
	}

	/*
		Get file mimetype
		
		Return
			string
	*/
	public function getMimetype(){
		return 'image/png';
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
		return exif_imagetype($path)==IMAGETYPE_PNG;
	}

}
