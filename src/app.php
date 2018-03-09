<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use TechTask\ControllerLoader;
use TechTask\ServiceLoader;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());

$servicesLoader = new ServiceLoader($app);
$servicesLoader->bindServicesIntoContainer();

return $app;
