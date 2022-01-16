<?php

use Juice\Controllers\MyController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $routes)
{
    $routes->add('home', '/')->controller([MyController::class, 'home']);
    $routes->add('dev', '/dev/{name}')->controller([MyController::class, 'dev']);
};

