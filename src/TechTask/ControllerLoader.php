<?php

namespace TechTask;

use Silex\Application;
use TechTask\Controller\LunchController;

class ControllerLoader
{
    /** @var Application */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function instantiateControllers()
    {
        $this->app['lunch.controller'] = function () {
            return new LunchController($this->app);
        };
    }

    public function bindRoutesToControllers()
    {
        $this->app->get('/lunch', "lunch.controller:getLunch");
    }
}
