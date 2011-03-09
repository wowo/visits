<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'                  => __DIR__.'/../vendor/symfony/src',
    'Sznapka'                  => __DIR__.'/../src',
    'Doctrine\\MongoDB'        => __DIR__.'/../vendor/doctrine-mongodb/lib',
    'Doctrine\\ODM\\MongoDB'   => __DIR__.'/../vendor/doctrine-mongodb-odm/lib',
    'Doctrine'                 => __DIR__.'/../vendor/doctrine/lib',
    'Zend\\Log'                => __DIR__.'/../vendor/zend-log',
));
$loader->registerPrefixes(array(
    'Twig_Extensions_'   => __DIR__.'/../vendor/twig-extensions/lib',
    'Twig_'              => __DIR__.'/../vendor/twig/lib',
    'Swift_'             => __DIR__.'/../vendor/swiftmailer/lib/classes',
));
$loader->register();
