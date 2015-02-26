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
        $this->v($d3)->h($w)->v($d3)->h(-$w)->v($d3);

        $this->h($w);
        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            $this->h($h3)->v($w)->h($h3)->v(-$w)->h($h3)->h($w);
        }

        $this->v(-$d3)->h(-$w)->v(-$d3)->h($w)->v(-$d3);

        $this->h(-$w);
        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            $this->h(-$cupBoard->boxHeight)->h(-$w);
        }
        $this->z();

        $this->m(0, $d3);
        for ($i = 1 ; $i < $cupBoard->y ; $i++) {
            $this->m($w + $cupBoard->boxHeight, 0);
            $this->v($d3)->h($w)->v(-$d3)->h(-$w)->z();
        }
    }
}
