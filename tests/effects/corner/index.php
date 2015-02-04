<?php

use Symfony\Component\ClassLoader\ClassLoader;

########################################################### Prepare

error_reporting(E_ALL);
ini_set('memory_limit','-1');
set_time_limit(0);

require '../../vendor/autoload.php';
require '../../../vendor/autoload.php';

$loader=new ClassLoader;
$loader->register();
$loader->addPrefix('Imagix',__DIR__.'/../../../src');

########################################################### Tests

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->corner();
$imagix=new Imagix\Image(new Imagix\Adapter\PNG($imagix->getAdapter()));
$imagix->save(__DIR__.'/image1.png');

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->corner(20,Imagix\Effect\Corner::TRUNCATED,Imagix\Effect\Corner::TOPRIGHT);
$imagix->corner(20,Imagix\Effect\Corner::TRUNCATED,Imagix\Effect\Corner::TOPLEFT);
$imagix->corner(20,Imagix\Effect\Corner::TRUNCATED,Imagix\Effect\Corner::BOTTOMRIGHT);
$imagix->corner(20,Imagix\Effect\Corner::TRUNCATED,Imagix\Effect\Corner::BOTTOMLEFT);
$imagix=new Imagix\Image(new Imagix\Adapter\PNG($imagix->getAdapter()));
$imagix->save(__DIR__.'/image2.png');

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->corner(20,Imagix\Effect\Corner::BEVELLED);
$imagix=new Imagix\Image(new Imagix\Adapter\PNG($imagix->getAdapter()));
$imagix->save(__DIR__.'/image3.png');

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Create corners</title>
	</head>
	<body>
		<img src="../../images/image.jpg" alt="">
		<img src="image1.png" alt="">
		<img src="image2.png" alt="">
		<img src="image3.png" alt="">
	</body>
</html>