<?php

namespace Imagix\Adapter;

use Imagix\Exception;

/*
	Abstract adapter
*/
abstract class AbstractAdapter implements AdapterInterface{

	/*
		resource $resource
		string $path
	*/
	protected $resource;
	protected $path;

	/*
		Constructor

		Parameters
			string, Imagix\Adapter\AbstractAdapter $spec
	*/
	public function __construct($spec){
		// Load file
		if(is_string($spec)){
			if(!filter_var($spec, FILTER_VALIDATE_URL) && !is_readable($spec)){
				throw new Exception("'$spec' is not readable or does not exist");
			}
			$this->path=$spec;
			$this->resource=$this->loadImage($spec);
			if(!$this->resource){
				throw new Exception("Failed to load '$spec', perhaps file is not readable or image contains few errors");
			}
		}
		// Load from another adapter
		elseif($spec instanceof self){
			$this->resource=$spec->getResource();
		}
		// Load directly the resource
		elseif(is_resource($spec)){
			$this->resource=$spec;
		}
		else{
			throw new Exception("Unexpected value encountered, expects a string, a Imagix\AbstractImage child object or a valid GD resource");
		}
	}

	/*
		Load image
		
		Parameters
			string $path
		
		Return
			resource, false
	*/
	abstract protected function loadImage($path);

	/*
		Set the new resource for the image
		
		Parameters
			resource $resource
	*/
	public function setResource($resource){
		if(!is_resource($resource)){
			throw new Exception("This is not a valid resource");
		}
		$this->resource=$resource;
	}

	/*
		Get current image resource
		
		Return
			resource
	*/
	public function getResource(){
		return $this->resource;
	}

	/*
		Get path
		
		Return
			string
	*/
	public function getPath(){
		return $this->path;
	}

}
