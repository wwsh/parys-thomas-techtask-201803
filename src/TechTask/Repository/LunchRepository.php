<?php

namespace TechTask\Repository;

use TechTask\Database\DatabaseInterface;
use TechTask\Model\Ingredient;
use TechTask\Model\Recipe;

/**
 * Software queries, sorting and data manipulation of recipes and ingredients.
 *
 * @package TechTask\Repository
 */
class LunchRepository
{
    /** @var DatabaseInterface */
    protected $db;

    /**
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->db = $database;
    }

    /**
     * Method should return recipe names, which can be used
     * and are bestBefore, sorted in descending order.
     * @param \DateTime $moment
     * @return Recipe[]
     */
    public function getValidRecipeNames(\DateTime $moment)
    {
        $recipes = $this->db->findAll();

        // filter out recipes, that are past use-by
        $recipes = $this->queryValidUseByRecipes($recipes, $moment);

        // sort least fresh to the bottom
        $this->sortByBestBeforeDesc($recipes, $moment);

        // return just the recipe names
        $recipes = $this->extractName($recipes);

        return $recipes;
    }

    /**
     * Returns Recipes that have valid used-by values.
     *
     * @param Recipe[] $recipes
     * @param \DateTime $moment
     * @return Recipe[]
     */
    protected function queryValidUseByRecipes(array $recipes, \DateTime $moment)
    {
        $result = array_filter(
            $recipes,
            function (Recipe $recipe) use ($moment) {
                return $this->isUsedByValid($recipe, $moment);
            }
        );

        $result = array_values($result);

        return $result;
    }

    /**
     * Returns a sorted Recipe array, where Recipes with expired best-before
     * are sorted to the bottom.
     *
     * @param Recipe[] $recipes
     * @param \DateTime $moment
     * @return Recipe[]
     */
    protected function sortByBestBeforeDesc(array &$recipes, \DateTime $moment)
    {
        $sorter = array_map(
            function (Recipe $recipe) use ($moment) {
                return $this->isBestBeforeValid($recipe, $moment);
            },
            $recipes
        );

        $check = array_unique($sorter);

        if (count($check) < 2) {
            // nothing to sort on
            return $recipes;
        }

        array_multisort($recipes, SORT_DESC, $sorter);

        return $recipes;
    }

    /**
     * Returns true if all ingredients are still "best before".
     *
     * @param Recipe $recipe
     * @param \DateTime $dateTime
     * @return boolean
     */
    protected function isBestBeforeValid(Recipe $recipe, \DateTime $dateTime)
    {
        $result = array_reduce(
            $recipe->getIngredients(),
            function ($decision, Ingredient $ingredient) use ($dateTime) {
                $check = $ingredient->getBestBefore() >= $dateTime;

                // whenever best-before is greater than NOW(), it's okay
                return $check === false ? false : $decision;
            },
            true
        );

        return $result;
    }

    /**
     * Returns true if all ingredients can be still used.
     *
     * @param Recipe $recipe
     * @param \DateTime $dateTime
     * @return boolean
     */
    protected function isUsedByValid(Recipe $recipe, \DateTime $dateTime)
    {
        $result = array_reduce(
            $recipe->getIngredients(),
            function ($decision, Ingredient $ingredient) use ($dateTime) {
                $check = $ingredient->getUseBy() >= $dateTime;

                // whenever used-by is greater than NOW(), it's okay
                return $check === false ? false : $decision;
            },
            true
        );

        return $result;
    }

    /**
     * @param Recipe[] $recipes
     * @return array
     */
    protected function extractName(array $recipes)
    {
        $result = array_map(
            function (Recipe $recipe) {
                return $recipe->getTitle();
            },
            $recipes
        );

        return $result;
    }
}