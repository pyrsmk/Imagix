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

$imagix=Imagix\Factory::forge(__DIR__.'/../../images/image.gif');
$imagix->truecolor();
$imagix->save(__DIR__.'/image1.gif');

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Convert to true colors</title>
	</head>
	<body>
		<img src="../../images/image.gif" alt="">
		<img src="image1.gif" alt="">
	</body>
</html>