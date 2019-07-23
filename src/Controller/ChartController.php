<?php

namespace App\Controller;

use App\Repository\CountyRepository;
use App\Repository\JobRepository;
use App\Repository\TradeRepository;
use Ghunti\HighchartsPHP\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChartController extends AbstractController
{
    /**
     * @Route("/chart", name="chart")
     */
    public function index(
        TradeRepository $tradeRepository,
        JobRepository $jobRepository,
        CountyRepository $countyRepository
    ) {
        $trades = $tradeRepository->findAll();

        foreach ($trades as $key => $trade) {
            $tradesData[$key]['name'] = $trade->getName();
            $tradesData[$key]['y'] = count($trade->getUsers());
        }

        $counties = $countyRepository->findAll();

        $tradeChart = new Highchart();

        $tradeChart->chart->renderTo = "tradeChart";
        $tradeChart->chart->height = 750;
        $tradeChart->chart->backgroundColor = 'rgba(0,55,0,0)';
        $tradeChart->title->text = "Corps de métiers au royaume";
        $tradeChart->title->style->fontSize = '2rem';

        $tradeChart->plotOptions->pie->allowPointSelect = true;
        $tradeChart->plotOptions->pie->cursor = 'pointer';
        $tradeChart->plotOptions->pie->dataLabels->enabled = true;
        $tradeChart->plotOptions->pie->dataLabels->format = '<p style="font-size: 1rem;">{point.name}</b><span style="font-size: 0.8rem;">: {point.percentage:.1f} %</span>';

        $tradeChart->tooltip->pointFormat = '{series.name}: <b>{point.percentage:.1f}%</b>';

        $tradeChart->series[] = [
            'type' => 'pie',
            'name' => 'Total',
            'colorByPoint' => true,
            'data' => $tradesData,
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
        $countyChart->title->style->fontSize = '2rem';

        $countyChart->plotOptions->pie->allowPointSelect = true;
        $countyChart->plotOptions->pie->cursor = 'pointer';
        $countyChart->plotOptions->pie->dataLabels->enabled = false;
        $countyChart->plotIptions->pie->showInLegend = true;

        $countyChart->legend->enable = true;
        $countyChart->legend->itemStyle->fontSize = '1rem';
        $countyChart->tooltip->pointFormat = '{series.name}: <b>{point.percentage:.1f}%</b>';

        $countyChart->series[] = [
            'type' => 'pie',
            'name' => '',
            'colorByPoint' => true,
            'data' => $countyData,
            'showInLegend' => true,
        ];

        return $this->render('chart/index.html.twig', [
            'tradeChart' => $tradeChart->render(),
            'countyChart' => $countyChart->render(),
        ]);
    }
}
