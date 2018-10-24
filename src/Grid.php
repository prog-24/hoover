<?php
/**
 * Created by PhpStorm.
 * User: aitspeko
 * Date: 22/10/2018
 * Time: 20:46
 */

namespace Promise\Hoover;


class Grid
{
    private $x;
    private $y;
    private $items;
    private $filename;

    /**
     * Grid constructor.
     * @param $x
     * @param $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->items = [];
        $this->filename = __DIR__.'/../instructions.txt';
        if(!file_exists($this->filename)) {
            touch($this->filename);
        }
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getItemsOfType($type)
    {
        $result = array_filter($this->items, function ($item) use ($type) {
            return get_class($item) === $type;
        });

        return $result;
    }

    public function getItem($item)
    {
        $result = array_filter($this->items, function ($it) use ($item) {
            return $it === $item;
        });

        return $result[0];
    }

    public function inGrid($item)
    {
        return !empty($this->getItem($item));
    }

    public function clean(Hoover $hoover)
    {
        $patches = $this->getItemsOfType(Dirt::class);
        $instructions = "";
        if (!empty($patches)) {
            /** @var Dirt $dirt */
            foreach ($patches as $dirt) {
                $instructions = $instructions . $this->moveItem($hoover, $dirt->getPosition());
            }
        }
        return [
            "coords" => [$hoover->getPosition()->getX(), $hoover->getPosition()->getY()],
            "patches" => count($patches),
            "instructions" => $instructions
        ];
    }

    public function getSize()
    {
        return $this->x * $this->y;
    }

    /**
     * @param $hoover Hoover
     * @param $position GridPosition
     */
    public function registerHoover($hoover, $position = null)
    {
        if (empty($position)) {
            $position = new GridPosition(0, 0);
        }
        $hoover->setPosition($position);
        $this->registerItem($hoover);
    }

    public function registerDirt(Dirt $dirt)
    {
        $this->registerItem($dirt);
    }

    protected function registerItem(GridItem $item) {
        $this->enforcePlacement($item);
        $this->items[] = $item;
    }

    private function enforcePlacement(GridItem $item)
    {
        if(!$this->checkValidPlacement($item)) {
            throw new \Exception("Object placement not allowed. Coordinates {$item->getPosition()} are greater than room size {$this->x},{$this->y}");
        }
    }

    private function checkValidPlacement(GridItem $item)
    {
        if(($item->getPosition()->getX() > $this->x) || ($item->getPosition()->getY() > $this->y)) {
            return false;
        }
        return true;
    }

    private function getMaxAllowedHoovers()
    {
        return $this->getSize() - 1;
    }

    /**
     * @param $item GridItem
     * @param GridPosition $position
     * @return string
     */
    public function moveItem(GridItem $item, GridPosition $position)
    {
        $instructions = "";
        if ($item->getPosition()->getX() < $position->getX()) {
            for ($i = $item->getPosition()->getX() + 1; $i <= $position->getX(); $i++) {
                $item->getPosition()->setX($i);
                $instructions = $instructions . "E";
            }
        } else {
            for ($i = $item->getPosition()->getX() - 1; $i >= $position->getX(); $i--) {
                $item->getPosition()->setX($i);
                $instructions = $instructions . "W";
            }
        }
        if ($item->getPosition()->getY() < $position->getY()) {
            for ($j = $item->getPosition()->getY() + 1; $j <= $position->getY(); $j++) {
                $item->getPosition()->setY($j);
                $instructions = $instructions . "N";
            }
        } else {
            for ($j = $item->getPosition()->getY() - 1; $j >= $position->getY(); $j--) {
                $item->getPosition()->setY($j);
                $instructions = $instructions . "S";
            }
        }

        $this->persistInstructions($this->getInstructions().$instructions);

        return $instructions;
    }

    public function getInstructions()
    {
        return file_get_contents($this->filename);
    }

    public function persistInstructions($instructions)
    {
        file_put_contents($this->filename, $instructions);
    }
}