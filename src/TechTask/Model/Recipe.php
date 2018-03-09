<?php

namespace TechTask\Model;

/**
 * Class representing a single recipe.
 *
 * @package TechTask\Model
 */
class Recipe
{
    /** @var string */
    protected $title;

    /** @var Ingredient[] */
    protected $ingredients;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Ingredient[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @param Ingredient[] $ingredients
     */
    public function setIngredients(array $ingredients): void
    {
        $this->ingredients = $ingredients;
    }
}