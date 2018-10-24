<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 22/10/2018
 * Time: 22:00
 */

namespace Promise\Hoover;


class GridPosition
{
    private $x;
    private $y;

    function __construct($x, $y)
    {
        $this->x = (int)$x;
        $this->y = (int)$y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    public function getSize()
    {
        return $this->x * $this->y;
    }

    public function __toString()
    {
        return "{$this->x},{$this->y}";
    }
}