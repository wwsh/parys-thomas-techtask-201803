<?php

namespace TechTask\Model;

/**
 * Class representing a single ingredient.
 *
 * @package TechTask\Model
 */
class Ingredient
{
    /** @var string */
    protected $title;

    /** @var \DateTime */
    protected $bestBefore;

    /** @var \DateTime */
    protected $useBy;

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
     * @return \DateTime
     */
    public function getBestBefore(): \DateTime
    {
        return $this->bestBefore;
    }

    /**
     * @param \DateTime $bestBefore
     */
    public function setBestBefore(\DateTime $bestBefore): void
    {
        $this->bestBefore = $bestBefore;
    }

    /**
     * @return \DateTime
     */
    public function getUseBy(): \DateTime
    {
        return $this->useBy;
    }

    /**
     * @param \DateTime $useBy
     */
    public function setUseBy(\DateTime $useBy): void
    {
        $this->useBy = $useBy;
    }
}