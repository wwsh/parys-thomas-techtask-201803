<?php

namespace TechTask\Controller;

use Silex\Application;

class LunchController
{
    /** @var Application */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(
        Application $app
    ) {
        $this->app = $app;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getLunch()
    {
        $result = $this->app['lunch.repository']
            ->getValidRecipeNames(new \DateTime());

        return $this->app->json($result);
    }
}
