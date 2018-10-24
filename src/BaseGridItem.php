<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 24/10/2018
 * Time: 16:03
 */

namespace Promise\Hoover;


class BaseGridItem implements GridItem
{
    /**
     * @var $position GridPosition
     */
    protected $position;

    /**
     * @param GridPosition $position
     */
    public function setPosition(GridPosition $position)
    {
        $this->position = $position;
    }

    /**
     * @return GridPosition
     */
    public function getPosition(): GridPosition
    {
        return $this->position;
    }
}