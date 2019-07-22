<?php

namespace App\Controller;

use App\Repository\CountyRepository;
use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Count;

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
    public function jobChart(JobRepository $jobRepository, CountyRepository $countyRepository)
    {
        $jobs = $jobRepository->findAll();
        $counties = $countyRepository->findAll();

        $jobData = [];

        foreach ($jobs as $key => $job) {
            $jobData[$key]['name'] = $job->getName();
            $jobData[$key]['y'] = count($job->getUsers());
        }

        $jobChart = new Highchart();

        $jobChart->chart->renderTo = "jobChart";
        $jobChart->chart->backgroundColor = 'rgba(0,55,0,0)';
        $jobChart->title->text = "Métiers au royaume";

        $jobChart->plotOptions->pie->allowPointSelect = true;
        $jobChart->plotOptions->pie->cursor = 'pointer';
        $jobChart->plotOptions->pie->dataLabels->enabled = true;
        $jobChart->plotOptions->pie->dataLabels->format = '<p style="font-size: 1rem;">{point.name}</b><span style="font-size: 0.8rem;">: {point.percentage:.1f} %</span>';

        $jobChart->tooltip->pointFormat = '{series.name}: <b>{point.percentage:.1f}%</b>';

        $jobChart->series[] = [
            'type' => 'pie',
            'name' => 'Total',
            'colorByPoint' => true,
            'data' => $jobData,
        ];

        $countyData = [];

        foreach ($counties as $key => $county) {
            $countyData[$key]['name'] = $county->getName();
            $countyData[$key]['y'] = count($county->getUsers());
        }

        $countyChart = new Highchart();

        $countyChart->chart->renderTo = "countyChart";
        $countyChart->chart->backgroundColor = 'rgba(0,55,0,0)';
        $countyChart->title->text = "Cellules du royaume";

        $countyChart->plotOptions->pie->allowPointSelect = true;
        $countyChart->plotOptions->pie->cursor = 'pointer';
        $countyChart->plotOptions->pie->dataLabels->enabled = false;
        $countyChart->plotIptions->pie->showInLegend = true;

        $countyChart->legend->enable = true;
        $countyChart->tooltip->pointFormat = '{series.name}: <b>{point.percentage:.1f}%</b>';

        $countyChart->series[] = [
            'type' => 'pie',
            'name' => '',
            'colorByPoint' => true,
            'data' => $countyData,
            'showInLegend' => true,
        ];

        return $this->render('chart/index.html.twig', [
            'jobChart' => $jobChart->render(),
            'countyChart' => $countyChart->render(),
        ]);
    }
}
