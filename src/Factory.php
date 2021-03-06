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
        switch(mimetype($path)) {
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
