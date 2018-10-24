<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 22/10/2018
 * Time: 20:42
 */

namespace Promise\Hoover\Tests;


use PHPUnit\Framework\TestCase;
use Promise\Hoover\Dirt;
use Promise\Hoover\Grid;
use Promise\Hoover\GridPosition;
use Promise\Hoover\Hoover;

class GridTest extends TestCase
{
    private $y;
    private $x;

    protected function setUp()
    {
        parent::setUp();

        $this->x = random_int(1, 5);
        $this->y = rand(3, 6);
    }

    public function testCreateGrid()
    {
        $grid = new Grid($this->x, $this->y);
        $this->assertTrue(is_object($grid));
    }

    public function testGridSize()
    {
        $grid = new Grid($this->x, $this->y);
        $this->assertEquals($this->x * $this->y, $grid->getSize());
    }

    public function testGridInteraction()
    {
        $grid = new Grid($this->x, $this->y);
        $grid->registerHoover((new Hoover));
        $this->assertEquals(1, count($grid->getItemsOfType(Hoover::class)));
        $grid->registerDirt(new Dirt((new GridPosition(random_int(0, $this->x), random_int(0, $this->y)))));
        $this->assertEquals(1, count($grid->getItemsOfType(Dirt::class)));
        $this->assertEquals(2, count($grid->getItems()));
    }

    public function testGridItemInteraction()
    {
        $grid = new Grid($this->x, $this->y);
        $hoover = (new Hoover);
        $grid->registerHoover($hoover);
        $hoover2 = (new Hoover);
        $this->assertEquals($hoover, $grid->getItems()[0]);
        $this->assertNotEquals($hoover2, $grid->getItems()[1]);
        $this->assertTrue($grid->inGrid($hoover));
        $newGridPosition = new GridPosition(random_int(0, $this->x), random_int(0, $this->y));
        $grid->moveItem($hoover, $newGridPosition);
        $this->assertEquals($hoover->getPosition()->getX(), $newGridPosition->getX());
        $this->assertEquals($hoover->getPosition()->getY(), $newGridPosition->getY());
        $newGridPosition2 = new GridPosition(random_int(0, $this->x), random_int(0, $this->y));
        $grid->moveItem($hoover, $newGridPosition2);
        $this->assertEquals($hoover->getPosition()->getX(), $newGridPosition2->getX());
        $this->assertEquals($hoover->getPosition()->getY(), $newGridPosition2->getY());
    }
}