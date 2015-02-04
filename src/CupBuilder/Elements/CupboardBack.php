<?php
namespace Vtk13\Cups\CupBuilder\Elements;

use Vtk13\Cups\CupBuilder\CupBoard;
use Vtk13\Cups\CupBuilder\Path;

class CupboardBack extends Path
{
    public function __construct(CupBoard $cupBoard)
    {
        $w3 = $cupBoard->boxWidth / 3;
        $h3 = $cupBoard->boxHeight / 3;
        $w = $cupBoard->weight;

        $this->m(0, 0);

        for ($i = 0 ; $i < $cupBoard->x ; $i++) {
            $this->h($w)->h($w3)->v($w)->h($w3)->v(-$w)->h($w3);
        }
        $this->h($w);

        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            $this->v($w)->v($h3)->h(-$w)->v($h3)->h($w)->v($h3);
        }
        $this->v($w);

        for ($i = 0 ; $i < $cupBoard->x ; $i++) {
            $this->h(-$w)->h(-$w3)->v(-$w)->h(-$w3)->v($w)->h(-$w3);
        }
        $this->h(-$w);

        for ($i = 0 ; $i < $cupBoard->y ; $i++) {
            $this->v(-$w)->v(-$h3)->h($w)->v(-$h3)->h(-$w)->v(-$h3);
        }
        $this->v(-$w)->z();

        $this->m(0, $w + $h3);
        for ($i = 2 ; $i <= $cupBoard->x ; $i++) {
            $this->m($w + $w3 * 3, 0);
            for ($j = 1 ; $j <= $cupBoard->y ; $j++) {
                $this->h($w)->v($h3)->h(-$w)->v(-$h3)->z();
                if ($j < $cupBoard->y) {
                    $this->m(0, $w + 3 * $h3);
                }
            }
            $this->m(0, -($cupBoard->y - 1) * ($w + 3 * $h3));
        }
        // back to point 0, 0
        $this->m(-($cupBoard->x - 1) * ($w + $w3 * 3), - $w - $h3);

        $this->m($w + $w3, 0);
        for ($i = 2 ; $i <= $cupBoard->y ; $i++) {
            $this->m(0, $w + $h3 * 3);
            for ($j = 1 ; $j <= $cupBoard->x ; $j++) {
                $this->v($w)->h($w3)->v(-$w)->h(-$w3)->z();
                if ($j < $cupBoard->x) {
                    $this->m($w + 3 * $w3, 0);
                }
            }
            $this->m(-($cupBoard->x - 1) * ($w + 3 * $w3), 0);
        }
        // back to point 0, 0
        $this->m(- $w - $w3, -($cupBoard->y - 1) * ($w + $h3 * 3));
    }
}
