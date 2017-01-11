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
        switch(substr(strtolower(pathinfo($path, PATHINFO_EXTENSION)), 0, 3)) {
            case 'jpg':
            case 'jpe':
                return new Image(new Adapter\JPEG($path));
                break;
            case 'png':
                return new Image(new Adapter\PNG($path));
                break;
            case 'gif':
                return new Image(new Adapter\GIF($path));
                break;
            default:
                throw new Exception("'$path' image file is not supported");
        }
	}
	
}
