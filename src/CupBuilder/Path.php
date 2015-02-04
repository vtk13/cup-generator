<?php
namespace Vtk13\Cups\CupBuilder;

class Path
{
    protected $commands = [];

    protected $x = 0, $y = 0; // current x, y.
    protected $minX = 0, $maxX = 0, $minY = 0, $maxY = 0;

    public function m($x, $y)
    {
        $this->commands[] = "m {$this->x($x)},{$this->y($y)}";
        return $this;
    }

    public function l($x, $y)
    {
        $this->commands[] = "l {$this->x($x)},{$this->y($y)}";
        return $this;
    }

    public function h($x)
    {
        $this->commands[] = "h {$this->x($x)}";
        return $this;
    }

    public function v($y)
    {
        $this->commands[] = "v {$this->y($y)}";
        return $this;
    }

    public function z()
    {
        $this->commands[] = 'z';
        return $this;
    }

    // handle relative offset
    protected function x($x)
    {
        $this->x += $x;
        $this->minX = min($this->minX, $this->x);
        $this->maxX = max($this->maxX, $this->x);
        return $x;
    }

    // handle relative offset
    protected function y($y)
    {
        $this->y += $y;
        $this->minY = min($this->minY, $this->y);
        $this->maxY = max($this->maxY, $this->y);
        return $y;
    }

    public function getWidth()
    {
        return $this->maxX - $this->minX;
    }

    public function getHeight()
    {
        return $this->maxY - $this->minY;
    }

    public function __toString()
    {
        return implode(' ', $this->commands);
    }
}
