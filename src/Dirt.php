<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 22/10/2018
 * Time: 23:46
 */

namespace Promise\Hoover;


class Dirt extends BaseGridItem
{
    /**
     * Dirt constructor.
     * @param GridPosition $position
     */
    public function __construct(GridPosition $position)
    {
        $this->position = $position;
    }
}