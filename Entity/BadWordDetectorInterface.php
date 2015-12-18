<?php

namespace RenowazeBundle\Entity;

interface BadWordDetectorInterface
{

    /**
     * @return bool
     */
    public function getHasBadWords();

    /**
     * @param boolean $hasBadWords
     *
     * @return $this
     */
    public function setHasBadWords($hasBadWords);
}