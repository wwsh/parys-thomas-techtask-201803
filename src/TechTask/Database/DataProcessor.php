<?php

namespace TechTask\Database;

use TechTask\Database\DataProcessor\ProcessorInterface;

/**
 * Class responsible for preparing the data for mapping.
 *
 * @package TechTask\Database
 */
class DataProcessor
{
    /**
     * @var ProcessorInterface[]
     */
    protected $processors;

    /**
     * @param $processors
     */
    public function __construct($processors)
    {
        $this->processors = $processors;
    }

    /**
     * @param array $data
     * @return array
     */
    public function process(array $data)
    {
        if (empty($data)) {
            return $data;
        }

        foreach ($data as $key => $value) {
            foreach ($this->processors as $processor) {
                $data[$key] = $processor
                    ->process($value);
            }
        }

        return $data;
    }
}
