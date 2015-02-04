<?php
namespace Vtk13\Cups\Controllers;

use Vtk13\Cups\CupBuilder\CupBoard;
use Vtk13\Mvc\Handlers\AbstractController;
use Vtk13\Mvc\Http\Response;

class IndexController extends AbstractController
{
    public function __construct()
    {
        parent::__construct('index');
    }

    public function indexGET()
    {

    }

    public function indexPOST()
    {
        $cupboard = new CupBoard(
            (int)$_POST['boxWidth'],
            (int)$_POST['boxHeight'],
            (int)$_POST['boxDepth'],
            (int)$_POST['weight'],
            (int)$_POST['x'],
            (int)$_POST['y']
        );

        return new Response(
            $cupboard->buildSVG()->asXML(),
            200,
            ['Content-Type' => 'image/svg+xml']
        );
    }
}
