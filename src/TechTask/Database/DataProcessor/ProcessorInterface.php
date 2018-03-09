<?php

namespace TechTask\Database\DataProcessor;

interface ProcessorInterface
{
    /**
     * @param array $row
     * @return array
     */
    public function process($row);
}
