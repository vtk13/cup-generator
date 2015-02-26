<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\CupBoard;
use Vtk13\Cups\CupBuilder\Path;

class CupboardMiddleVertical extends Path
{
    public function __construct(CupBoard $cupBoard)
    {
        $d3 = $cupBoard->boxDepth / 3;
        $d2 = $cupBoard->boxDepth / 2;
        $h3 = $cupBoard->boxHeight / 3;
        $w = $cupBoard->weight;

        $this->m($w, 0);
        $this->v($d3)->h(-$w)->v($d3)->h($w)->v($d3);
        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            if ($i > 0) {
                $this->h($w);
            }
            $this->h($h3)->v($w)->h($h3)->v(-$w)->h($h3);
        }
        $this->v(-$d3)->h($w)->v(-$d3)->h(-$w)->v(-$d3);

        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            if ($i > 0) {
                $this->v($d2)->h(-$w)->v(-$d2);
            }
            $this->h(-$cupBoard->boxHeight);
        }
        $this->z();
    }
}
