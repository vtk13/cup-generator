<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\CupBoard;
use Vtk13\Cups\CupBuilder\Path;

class CupboardTopBottom extends Path
{
    public function __construct(CupBoard $cupBoard)
    {
        $width = $cupBoard->boxWidth;
        $w3 = $cupBoard->boxWidth / 3;
        $d3 = $cupBoard->boxDepth / 3;
        $w = $cupBoard->weight;

        $this->m($w, $w);
        for ($i = 0 ; $i < $cupBoard->x ; $i++) {
            if ($i > 0) {
                $this->h($w);
            }
            $this->h($w3)->v(-$w)->h($w3)->v($w)->h($w3);
        }
        $this->v($d3)->h($w)->v($d3)->h(-$w)->v($d3);

        for ($i = 0 ; $i < $cupBoard->x ; $i++) {
            if ($i > 0) {
                $this->h(-$w);
            }
            $this->h(-$width);
        }

        $this->v(-$d3)->h(-$w)->v(-$d3)->h($w)->v(-$d3)->z();

        $this->m(-$w, $d3);
        for ($i = 1 ; $i < $cupBoard->x ; $i++) {
            $this->m($w + $width, 0)->h($w)->v($d3)->h(-$w)->v(-$d3)->z();
        }
    }
}
