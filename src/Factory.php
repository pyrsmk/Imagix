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
        // Get image mimetype
        if(filter_var($path, FILTER_VALIDATE_URL)) {
            $request = curl_init($path);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_NOBODY, true);
            curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($request);
            $mimetype = curl_getinfo($request, CURLINFO_CONTENT_TYPE);
        }
        else {
            $mimetype = getimagesize($path)['mime'];
        }
        // Load image
        switch($mimetype) {
            case 'image/jpeg':
                return new Image(new Adapter\JPEG($path));
                break;
            case 'image/png':
                return new Image(new Adapter\PNG($path));
                break;
            case 'image/gif':
                return new Image(new Adapter\GIF($path));
                break;
            default:
                throw new Exception("'$path' image file is not supported");
        }
	}
	
}
