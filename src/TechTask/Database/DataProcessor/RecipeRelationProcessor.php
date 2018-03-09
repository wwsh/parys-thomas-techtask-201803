<?php

namespace TechTask\Database\DataProcessor;

use TechTask\Database\DataLoader;

/**
 * Custom processor for merging ingredients data into the recipe data.
 *
 * @package TechTask\Database\DataProcessor
 */
class RecipeRelationProcessor implements ProcessorInterface
{
    /** @var DataLoader */
    protected $loader;

    /** @var array */
    protected $data;

    /** @var string */
    protected $resourceToLoad;

    /**
     * @param DataLoader $loader
     * @param string $resourceToLoad
     */
    public function __construct(DataLoader $loader, string $resourceToLoad)
    {
        $this->loader = $loader;
        $this->resourceToLoad = $resourceToLoad;
    }

    /**
     * This method is merging ingredients' relations into each recipe.
     *
     * @param array $row
     * @return array
     */
    public function process($row)
    {
        $this->init();

        if (isset($row->ingredients)) {
            foreach ($row->ingredients as $key => $value) {
                $row->ingredients[$key] = $this->getIngredient($value);
            }
        }

        return $row;
    }

    protected function init()
    {
        if (!empty($this->data)) {
            return;
        }

        $data = $this->loader->load($this->resourceToLoad);

        $this->data = $data;
    }

    /**
     * @param $title
     * @return null
     */
    protected function getIngredient($title)
    {
        foreach ($this->data as $key => $values) {
            if ($title === $values->title) {
                return $values;
            }
        }

        return null;
    }
}