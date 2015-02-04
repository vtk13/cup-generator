<?php
namespace Vtk13\Cups\CupBuilder;

use EasySVG;
use SplObjectStorage;

class Packer
{
    protected $elements = [];
    protected $maxWidth;
    protected $x = 0, $y = 0;
    protected $currentMaxHeight = 0;

    public function __construct($maxWidth)
    {
        $this->maxWidth = $maxWidth;
    }

    public function add(Path $el)
    {
        if ($el->getWidth() > $this->maxWidth) {
            throw new \Exception("Can't place element with width #{$el->getWidth()}, max width is {$this->maxWidth}");
        }

        if ($this->x + $el->getWidth() > $this->maxWidth) {
            $this->x = 0;
            $this->y += $this->currentMaxHeight;
            $this->currentMaxHeight = 0;
        }

        $this->elements[$this->x . ':' . $this->y] = $el;

        $this->x += $el->getWidth();
        $this->currentMaxHeight = max($this->currentMaxHeight, $el->getHeight());
    }

    public function getWidth()
    {
        return $this->maxWidth;
    }

    public function getHeight()
    {
        return $this->y + $this->currentMaxHeight;
    }

    public function draw(EasySVG $svg, array $pathParams)
    {
        /* @var $el Path */
        foreach ($this->elements as $xy => $el) {
            list($x, $y) = explode(':', $xy);
            $svg->addPath("M {$x},{$y} " . $el->__toString(), $pathParams);
        }
    }
}
