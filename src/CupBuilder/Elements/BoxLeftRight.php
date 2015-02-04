<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\Path;

class BoxLeftRight extends Path
{
    public function __construct($width, $height, $depth, $weight)
    {
        $d3 = $depth / 3;
        $h3 = $height / 3;

        $this->m(0, 0)
            ->h($d3)->h($d3)->h($d3)
            ->v($h3)->h(-$weight)->v($h3)->h($weight)->v($h3 - $weight)
            ->h(-$d3)->v($weight)->h(-$d3)->v(-$weight)->h(-$d3)
            ->v(-$h3 + $weight)->h($weight)->v(-$h3)->h(-$weight)->z();
    }
}
