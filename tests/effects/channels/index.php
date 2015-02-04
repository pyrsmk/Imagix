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
$imagix->channels(Imagix\Effect\Channels::GREEN,Imagix\Effect\Channels::RED,Imagix\Effect\Channels::BLUE);
$imagix->save(__DIR__.'/image1.jpg');

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->channels(Imagix\Effect\Channels::MAXIMIZE,Imagix\Effect\Channels::NONE,Imagix\Effect\Channels::NONE);
$imagix->save(__DIR__.'/image2.jpg');

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->channels(Imagix\Effect\Channels::MINIMIZE,Imagix\Effect\Channels::NONE,Imagix\Effect\Channels::NONE);
$imagix->save(__DIR__.'/image3.jpg');

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Adjust RGB channels</title>
	</head>
	<body>
		<img src="../../images/image.jpg" alt="">
		<img src="image1.jpg" alt="">
		<img src="image2.jpg" alt="">
		<img src="image3.jpg" alt="">
	</body>
</html>