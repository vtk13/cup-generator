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

        $this->m(0, $w);
        $this->h($d3)->v(-$w)->h($d3)->v($w)->h($d3);
        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            if ($i > 0) {
                $this->v($w);
            }
            $this->v($h3)->h($w)->v($h3)->h(-$w)->v($h3);
        }
        $this->h(-$d3)->v($w)->h(-$d3)->v(-$w)->h(-$d3);

        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            if ($i > 0) {
                $this->h($d2)->v(-$w)->h(-$d2);
            }
            $this->v(-$cupBoard->boxHeight);
        }
        $this->z();
    }
}
