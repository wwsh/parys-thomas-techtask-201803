<?php

namespace TechTask\Database;

use JsonMapper;

/**
 * Class responsible for converting the json object into models.
 *
 * @package TechTask\Database
 */
class ModelMapper
{
    /** @var string */
    protected $mapToClass;

    /**
     * @param string $mapToClass
     */
    public function __construct(string $mapToClass)
    {
        $this->mapToClass = $mapToClass;
    }

    /**
     * @param array $data
     * @return object[]
     */
    public function map(array $data)
    {
        $mapper = new JsonMapper();

        $result = $mapper->mapArray(
            $data,
            [],
            $this->mapToClass
        );

        return $result;
    }
}
