<?php

namespace Imagix;

use Imagix\Adapter\AbstractAdapter;

/*
	Image base class
*/
class Image{

	/*
		Imagix\Adapter\AbstractAdapter $adapter
	*/
	protected $adapter;

	/*
		Constructor
		
		Parameters
			Imagix\Adapter\AbstractAdapter $adapter
	*/
	public function __construct(AbstractAdapter $adapter){
		$this->adapter=$adapter;
	}

	/*
		Get adapter
		
		Return
			Imagix\Adapter\AbstractAdapter
	*/
	public function getAdapter(){
		return $this->adapter;
	}

	/*
		Save image file
		
		Parameters
			array $path		: image path
			array $options	: adapter options
		
		Return
			string
	*/
	public function save($path='',array $options=array()){
		if(!$path){
			if(!$this->path){
				throw new Exception("Wrong path specified");
			}
			$path=$this->path;
		}
		else if(substr($path,-1)=='/'){
			if(!$this->path){
				throw new Exception("Wrong path specified");
			}
			$path.=pathinfo($this->path,PATHINFO_BASENAME);
		}
		if(!file_put_contents($path,$this->adapter->getContents($options))){
			throw new Exception("Error encountered while saving '$path'");
		}
		$this->path=$path;
		return $path;
	}

	/*
		Apply a graphic effect
		
		Parameters
			string $name
			array $parameters
		
		Return
			Imagix
	*/
	public function __call($name,$parameters){
		// Verify name
		$name=ucfirst(strtolower((string)$name));
		if($name=='abstracteffect' || $name=='exception'){
			throw new Exception("'$name' is not a valid effect");
		}
		// Instantiate effect plugin
		$class='\Imagix\Effect\\'.$name;
		$effect=new $class;
		// Verify class
		if(!is_subclass_of($effect,'\Imagix\Effect\AbstractEffect')){
			throw new Exception("Cannot apply '$name' effect, '$class' must extends 'Imagix\Effect\AbstractEffect'");
		}
		// Apply effect
		array_unshift($parameters,$this->adapter->getResource());
		$this->adapter->setResource(call_user_func_array(array($effect,'apply'),$parameters));
		return $this;
	}

	/*
		Get image width
		
		Return
			integer
	*/
	public function getWidth(){
		$width=imagesx($this->adapter->getResource());
		if(!$width){
			throw new Exception("Error encountered while getting image width");
		}
		return $width;
	}

	/*
		Get image height
		
		Return
			integer
	*/
	public function getHeight(){
		$height=imagesy($this->adapter->getResource());
		if(!$height){
			throw new Exception("Error encountered while getting image height");
		}
		return $height;
	}

}
