<?php

namespace TechTask\Database\Driver;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class JSON implements DriverInterface
{
    /**
     * @param array $resource
     * @return object
     */
    public function load(array $resource)
    {
        $result = $this->singleLoad($resource['resource']);

        if (isset($resource['options']['json.starting_property'])) {
            $startingProperty = $resource['options']['json.starting_property'];

            $result = $result->$startingProperty;
        }

        return $result;
    }

    /**
     * @param string $file
     * @return object
     */
    protected function singleLoad(string $file)
    {
        $content = file_get_contents($file);

        if (!$content) {
            throw new FileNotFoundException('Could not load file: ' . $file);
        }

        $elements = json_decode($content);

        return $elements;
    }
}