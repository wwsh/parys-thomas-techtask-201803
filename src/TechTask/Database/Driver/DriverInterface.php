<?php

namespace TechTask\Database\Driver;

interface DriverInterface
{
    /**
     * @param array $resource
     * @return mixed
     */
    public function load(array $resource);
}
