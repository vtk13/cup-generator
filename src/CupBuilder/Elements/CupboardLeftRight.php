<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\CupBoard;
use Vtk13\Cups\CupBuilder\Path;

class CupboardLeftRight extends Path
{
    public function __construct(CupBoard $cupBoard)
    {
        $d3 = $cupBoard->boxDepth / 3;
        $h3 = $cupBoard->boxHeight / 3;
        $w = $cupBoard->weight;

        $this->m(0, 0);
        $this->h($d3)->v($w)->h($d3)->v(-$w)->h($d3);

        $this->v($w);
        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            $this->v($h3)->h($w)->v($h3)->h(-$w)->v($h3)->v($w);
        }

        $this->h(-$d3)->v(-$w)->h(-$d3)->v($w)->h(-$d3);

        $this->v(-$w);
        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            $this->v(-$cupBoard->boxHeight)->v($w);
        }
        $this->z();

        $this->m($d3, 0);
        for ($i = 1 ; $i < $cupBoard->y ; $i++) {
            $this->m(0, $w + $cupBoard->boxHeight);
            $this->h($d3)->v($w)->h(-$d3)->v(-$w)->z();
        }
    }
}
