<?php
namespace Vtk13\Cups\CupBuilder;

use EasySVG;
use Vtk13\Cups\CupBuilder\Elements\BoxBottom;
use Vtk13\Cups\CupBuilder\Elements\BoxFrontBack;
use Vtk13\Cups\CupBuilder\Elements\BoxLeftRight;
use Vtk13\Cups\CupBuilder\Elements\CupboardBack;
use Vtk13\Cups\CupBuilder\Elements\CupboardLeftRight;
use Vtk13\Cups\CupBuilder\Elements\CupboardMiddleHorizontal;
use Vtk13\Cups\CupBuilder\Elements\CupboardMiddleVertical;
use Vtk13\Cups\CupBuilder\Elements\CupboardTopBottom;

class CupBoard
{
    public $boxWidth, $boxHeight, $boxDepth, $weight, $x, $y;
    public $includeBoxes;

    public function __construct($unitWidth, $unitHeight, $unitDepth, $weight, $x, $y, $includeBoxes = true)
    {
        $this->boxWidth     = $unitWidth;
        $this->boxHeight    = $unitHeight;
        $this->boxDepth     = $unitDepth;
        $this->weight       = $weight;
        $this->x = $x;
        $this->y = $y;
        $this->includeBoxes = $includeBoxes;
    }

    public function buildSVG()
    {
        $svg = new EasySVG();
        $svg->addAttribute('xmlns', 'http://www.w3.org/2000/svg');

        // нижняя и верхняя общие стенки
        $ctb = new CupboardTopBottom($this);
        // левая и права общие стенки
        $clr = new CupboardLeftRight($this);
        // задняя общая стенка
        $cb = new CupboardBack($this);

        $elements = [
            $cb, $ctb, $ctb, $clr, $clr
        ];

        // вертикальные промежуточные стенки
        $cmv = new CupboardMiddleVertical($this);
        for ($i = 1 ; $i < $this->x ; $i++) {
            $elements[] = $cmv;
        }

        // горизонтальные промежуточные стенки
        $cmh = new CupboardMiddleHorizontal($this);
        for ($i = 1 ; $i < $this->y ; $i++) {
            $elements[] = $cmh;
        }

        if ($this->includeBoxes) {
            $boxGap = 0.5;
            $bb = new BoxBottom   ($this->boxWidth - $boxGap, $this->boxHeight - $boxGap, $this->boxDepth, $this->weight);
            $blr = new BoxLeftRight($this->boxWidth - $boxGap, $this->boxHeight - $boxGap, $this->boxDepth, $this->weight);
            $bfb = new BoxFrontBack($this->boxWidth - $boxGap, $this->boxHeight - $boxGap, $this->boxDepth, $this->weight);
            for ($i = 0; $i < $this->x * $this->y; $i++) {
                $elements[] = $bb;
                $elements[] = $blr;
                $elements[] = $blr;
                $elements[] = $bfb;
                $elements[] = $bfb;
            }
        }

        usort($elements, function(Path $e1, Path $e2) {
            return $e1->getHeight() - $e2->getHeight();
        });

        $best = 400; $bestSquare = 1e9;
        for ($i = 300 ; $i < 900 ; $i += 10) {
            try {
                $packer = new Packer($i);
                foreach ($elements as $el) {
                    $packer->add($el);
                }
                if ($packer->getWidth() * $packer->getHeight() < $bestSquare) {
                    $bestSquare = $packer->getWidth() * $packer->getHeight();
                    $best = $i;
                }
            } catch (\Exception $ex) {}
        }

        $packer = new Packer($best);
        foreach ($elements as $el) {
            $packer->add($el);
        }
        $packer->draw($svg, ['fill' => 'none', 'stroke' => 'black', 'stroke-width' => '0.2']);

        $svg->addAttribute('width', $packer->getWidth() . 'mm');
        $svg->addAttribute('height', $packer->getHeight() . 'mm');
        $svg->addAttribute('viewBox', "0 0 {$packer->getWidth()} {$packer->getHeight()}");

        return $svg;
    }
}
