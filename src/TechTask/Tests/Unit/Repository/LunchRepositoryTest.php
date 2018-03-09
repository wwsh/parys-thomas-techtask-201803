<?php

namespace TechTask\Tests\Unit\Repository;

use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\VarDumper\Cloner\Data;
use TechTask\Database\DatabaseInterface;
use TechTask\Model\Ingredient;
use TechTask\Model\Recipe;
use TechTask\Repository\LunchRepository;
use PHPUnit\Framework\TestCase;

class LunchRepositoryTest extends TestCase
{
    /** @var array */
    protected $exampleData = [
        [
            'title'       => 'Example Recipe',
            'ingredients' => [
                [
                    'title'       => 'First ingredient',
                    'used-by'     => '2018-07-01',
                    'best-before' => '2018-06-01'
                ],
                [
                    'title'       => 'Second ingredient',
                    'used-by'     => '2018-01-01',
                    'best-before' => '2017-12-01'
                ],
                [
                    'title'       => 'Third ingredient',
                    'used-by'     => '2017-01-01',
                    'best-before' => '2016-12-01'
                ]
            ],
        ],
        [
            'title'       => 'Example Recipe 2',
            'ingredients' => [
                [
                    'title'       => 'First ingredient',
                    'used-by'     => '2018-04-01',
                    'best-before' => '2018-03-01'
                ],
                [
                    'title'       => 'Second ingredient',
                    'used-by'     => '2018-01-01',
                    'best-before' => '2017-12-01'
                ]
            ],
        ],
    ];

    /** @var LunchRepository */
    protected $testable;

    public function setUp()
    {
        parent::setUp();

        $this->prepareSampleData();

        /** @var MockObject|DatabaseInterface $db */
        $db = $this->createMock(DatabaseInterface::class);

        $db->method('findAll')
            ->willReturn($this->exampleData);

        $this->testable = new LunchRepository($db);
    }

    /**
     * @dataProvider dataProvider
     * @param $moment
     * @param $expected
     */
    public function testGetValidRecipes($moment, $expected)
    {
        $result = $this->testable->getValidRecipeNames($moment);

        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [
                // nothing is too old
                new \DateTime('2016-01-01'),
                [
                    'Example Recipe',
                    'Example Recipe 2'
                ]
            ],
            [
                // we're past the used-by of the first recipe
                new \DateTime('2017-01-02'),
                [
                    'Example Recipe 2'
                ]
            ],
            [
                // we're off the best before of the first recipe
                // should be pushed to bottom
                new \DateTime('2016-12-30'),
                [
                    'Example Recipe 2',
                    'Example Recipe'
                ]
            ],
        ];
    }

    protected function prepareSampleData()
    {
        $result = [];

        foreach ($this->exampleData as $recipeData) {
            $recipe = new Recipe();
            $recipe->setTitle($recipeData['title']);
            $ingredients = [];
            foreach ($recipeData['ingredients'] as $ingredientData) {
                $ingredient = new Ingredient();
                $ingredient->setTitle($ingredientData['title']);
                $ingredient->setBestBefore($this->getDate($ingredientData['best-before']));
                $ingredient->setUseBy($this->getDate($ingredientData['used-by']));
                $ingredients[] = $ingredient;
            }
            $recipe->setIngredients($ingredients);
            $result[] = $recipe;
        }

        $this->exampleData = $result;
    }

    /**
     * @param string $date
     * @return \DateTime
     */
    protected function getDate(string $date)
    {
        return new \DateTime($date);
    }
}
