<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

//mongodb
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
AnnotationDriver::registerAnnotationClasses();

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
