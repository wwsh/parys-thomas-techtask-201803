<?php

namespace TechTask;

use Silex\Application;
use TechTask\Database\DatabaseFacade;
use TechTask\Database\DataLoader;
use TechTask\Database\DataProcessor;
use TechTask\Database\DataProcessor\RecipeRelationProcessor;
use TechTask\Database\ModelMapper;
use TechTask\Repository\LunchRepository;

class ServiceLoader
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

    public function bindServicesIntoContainer()
    {
        $this->bindDbServices();

        $this->app['lunch.repository'] = function () {
            return new LunchRepository(
                $this->app['database.facade']
            );
        };
    }

    private function bindDbServices(): void
    {
        $this->app['database.loader'] = function () {
            return new DataLoader(
                $this->app['database.resources'],
                $this->app['database.driver']
            );
        };

        $this->app['database.processors'] = function () {
            return [new RecipeRelationProcessor(
                $this->app['database.loader'],
                $this->app['database.recipe_processor.resource']
            )];
        };

        $this->app['database.mapper'] = function () {
            return new ModelMapper($this->app['database.mapper.class']);
        };

        $this->app['database.processor'] = function () {
            return new DataProcessor($this->app['database.processors']);
        };

        $this->app['database.facade'] = function () {
            return new DatabaseFacade(
                $this->app['database.loader'],
                $this->app['database.facade.resource'],
                $this->app['database.processor'],
                $this->app['database.mapper']
            );
        };
    }
}
