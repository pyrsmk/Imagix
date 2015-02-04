<?php

namespace Imagix\Adapter;

/*
	Adapter interface
*/
interface AdapterInterface{

	/*
		Get image contents
		
		Parameters
			array $options
		
		Return
			string
	*/
	public function getContents(array $options);

	/*
		Get file extension
	
		Return
			string
	*/
	public function getExtension();

	/*
		Get file mimetype
		
		Return
			string
	*/
	public function getMimetype();

	/*
		Verify if the provided file is compatible
		
		Parameters
			string $path
		
		Return
			boolean
	*/
	static public function supports($path);

}
