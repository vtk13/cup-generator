<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\Path;

class BoxFrontBack extends Path
{
    public function __construct($width, $height, $depth, $weight)
    {
        $w3 = $width / 3;
        $h3 = $height / 3;

        $this->m($weight, 0)
            ->h($w3 - $weight)->h($w3)->h($w3 - $weight)
            ->v($h3)->h($weight)->v($h3)->h(-$weight)->v($h3 - $weight)
            ->h(-$w3 + $weight)->v($weight)->h(-$w3)->v(-$weight)->h(-$w3 + $weight)
            ->v(-$h3 + $weight)->h(-$weight)->v(-$h3)->h($weight)->z();
    }
}
