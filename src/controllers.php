<?php

use TechTask\ControllerLoader;

$controllerLoader = new ControllerLoader($app);
$controllerLoader->instantiateControllers();
$controllerLoader->bindRoutesToControllers();
