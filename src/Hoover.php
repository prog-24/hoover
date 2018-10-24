<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 22/10/2018
 * Time: 21:54
 */

namespace Promise\Hoover;


class Hoover extends BaseGridItem
{
    /**
     * @var null
     */
    private $title;

    /**
     * Hoover constructor.
     * @param null $title
     */
    public function __construct($title = null)
    {

        $this->title = $title;
        $this->position = null;
    }
}