<?php

namespace RenowazeBundle\Entity;

trait BadWordTrait
{

    /**
     * @var bool
     * @ORM\Column(name="hasBadWords", type="boolean")
     */
    private $hasBadWords;

    /**
     * Set hasBadWords
     * @param boolean $hasBadWords
     * @return $this
     */
    public function setHasBadWords($hasBadWords)
    {
        $this->hasBadWords = $hasBadWords;

        return $this;
    }

    /**
     * Get hasBadWords
     * @return bool
     */
    public function getHasBadWords()
    {
        return $this->hasBadWords;
    }
}