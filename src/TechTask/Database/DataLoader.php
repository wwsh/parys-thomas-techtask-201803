<?php

namespace TechTask\Database;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use TechTask\Database\Driver\DriverInterface;

/**
 * Class responsible for returning data as json object from the db storage.
 *
 * @package TechTask\Database
 */
class DataLoader
{
    /** @var array */
    protected $resources;

    /** @var DriverInterface */
    protected $driver;

    /**
     * @param array $resources
     * @param DriverInterface $driver
     */
    public function __construct(array $resources, DriverInterface $driver)
    {
        $this->resources = $resources;
        $this->driver    = $driver;
    }

    /**
     * @param string $resourceName
     * @return array|null
     */
    public function load(string $resourceName)
    {
        if (!isset($this->resources[$resourceName])) {
            throw new ResourceNotFoundException('Resource not found: ' . $resourceName);
        }

        $result = $this->driver->load($this->resources[$resourceName]);

        return $result;
    }
}
