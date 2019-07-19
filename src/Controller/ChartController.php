<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chart")
 * Class ChartController
 * @package App\Controller
 */
class ChartController extends AbstractController
{
    /**
     * @Route("/job", name="job_chart")
     */
    public function jobChart()
    {
        return $this->render('chart/index.html.twig', [
            'controller_name' => 'ChartController',
        ]);
    }
}
