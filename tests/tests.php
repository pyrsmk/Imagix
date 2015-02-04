<?php

use Symfony\Component\ClassLoader\ClassLoader;

########################################################### Prepare

error_reporting(E_ALL);

require 'vendor/autoload.php';
require '../vendor/autoload.php';

$loader=new ClassLoader;
$loader->register();
$loader->addPrefix('Imagix',__DIR__.'/../src');

$minisuite=new MiniSuite('Imagix');

########################################################### Imagix\Factory

$minisuite->group('Imagix\Factory',function($minisuite){

	$image=Imagix\Factory::forge('images/image.gif');

	$minisuite->expects('Instantiate a GIF')
			  ->that($image->getAdapter())
			  ->isInstanceOf('Imagix\Adapter\GIF');

	$image=Imagix\Factory::forge('images/image.jpg');

	$minisuite->expects('Instantiate a JPEG')
			  ->that($image->getAdapter())
			  ->isInstanceOf('Imagix\Adapter\JPEG');

	$image=Imagix\Factory::forge('images/image.png');

	$minisuite->expects('Instantiate a PNG')
			  ->that($image->getAdapter())
			  ->isInstanceOf('Imagix\Adapter\PNG');

});

########################################################### Imagix\Image

$minisuite->group('Imagix\Image',function($minisuite){

	$image=Imagix\Factory::forge('images/image.png');

	$minisuite->expects('getWidth()')
			  ->that($image->getWidth())
			  ->isGreaterThan(0);

	$minisuite->expects('getHeight()')
			  ->that($image->getHeight())
			  ->isGreaterThan(0);

	$minisuite->expects('save()')
			  ->that(function() use($image){
			  		$image->save('saved.png');
					new Imagix\Image(new Imagix\Adapter\PNG('saved.png',array('quality'=>5)));
			  })
			  ->doesNotThrow();

});

########################################################### Imagix\Adapter

$minisuite->group('Imagix\Adapter',function($minisuite){

	$png_adapter=new Imagix\Adapter\PNG('images/image.png');

	$minisuite->expects('getResource()')
			  ->that($png_adapter->getResource())
			  ->isResource();

	$jpg_adapter=new Imagix\Adapter\JPEG('images/image.jpg');
	$jpg_adapter->setResource($png_adapter->getResource());

	$minisuite->expects('setResource()')
			  ->that($jpg_adapter->getResource())
			  ->isTheSameAs($png_adapter->getResource());

	$minisuite->expects('Instantiate with a resource')
			  ->that(function() use($png_adapter){
			  		new Imagix\Adapter\JPEG($png_adapter->getResource());
			  })
			  ->doesNotThrow();

	$minisuite->expects('Instantiate with an adapter')
			  ->that(function() use($png_adapter){
			  		new Imagix\Adapter\JPEG($png_adapter);
			  })
			  ->doesNotThrow();

});