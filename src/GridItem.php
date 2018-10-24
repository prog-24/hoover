<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 22/10/2018
 * Time: 23:54
 */

namespace Promise\Hoover;


interface GridItem
{
    public function getPosition() : GridPosition;
    public function setPosition(GridPosition $position);
}