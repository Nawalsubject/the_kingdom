<?php

namespace App\Controller;

use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
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
    public function jobChart(JobRepository $jobRepository)
    {
        $jobs = $jobRepository->findAll();

        $data = [];

        foreach ($jobs as $key => $job) {
            $data[$key]['name'] = $job->getName();
            $data[$key]['y'] = count($job->getUsers());
        }

        dump($data);

        $chart = new Highchart();

        $chart->chart->renderTo = "container";
        $chart->chart->type = "pie";
        $chart->title->text = "Métiers au royaume";
        $chart->xAxis->type = "category";
        $chart->yAxis->title->text = "Pourcentage de royaumiens";

        $chart->plotOptions->pie->allowPointSelect = true;
        $chart->plotOptions->pie->cursor = 'pointer';
        $chart->plotOptions->pie->dataLabels->enabled = true;
        $chart->plotOptions->pie->dataLabels->format = '<b>{point.name}</b>: {point.percentage:.1f} %';

        $chart->tooltip->headerFormat = '<span style="font-size:11px">{series.name}</span><br>';
        $chart->tooltip->pointFormat = '{series.name}: <b>{point.percentage:.1f}%</b>';

        $chart->series[] = [
            'name' => '',
            'colorByPoint' => true,
            'data' => $data,
        ];

        return $this->render('chart/index.html.twig', [
            'chart' => $chart->render(),
        ]);
    }
}
