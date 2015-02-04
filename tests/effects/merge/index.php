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

//`$image`,`$method`,`$x1`,`$y1`,`$x2`,`$y2`,`$src_w`,`$src_h`,`$pct`

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->merge($imagix->getAdapter()->getResource(),Imagix\Effect\Merge::NORMAL,0,0,200,200,200,200,50);
$imagix->save(__DIR__.'/image1.jpg');

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.jpg');
$imagix->merge($imagix->getAdapter()->getResource(),Imagix\Effect\Merge::GRAYSCALE,0,0,200,200,200,200,50);
$imagix->save(__DIR__.'/image2.jpg');

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Merge two images</title>
	</head>
	<body>
		<img src="../../images/image.jpg" alt="">
		<img src="image1.jpg" alt="">
		<img src="image2.jpg" alt="">
	</body>
</html>