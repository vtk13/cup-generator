<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\Path;

class BoxBottom extends Path
{
    public function __construct($width, $height, $depth, $weight)
    {
        $w3 = $width / 3;
        $d3 = $depth / 3;

        $this->m(0, 0)
            ->h( $w3)->v( $weight)->h( $w3)->v(-$weight)->h( $w3)
            ->v( $d3)->h(-$weight)->v( $d3)->h( $weight)->v( $d3)
            ->h(-$w3)->v(-$weight)->h(-$w3)->v( $weight)->h(-$w3)
            ->v(-$d3)->h( $weight)->v(-$d3)->h(-$weight)->z();
    }
}
