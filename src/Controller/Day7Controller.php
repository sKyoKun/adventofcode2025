<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day7Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day7', name: 'day7')]
class Day7Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day7Services $day7services,
        private CalendarServices $calendarServices
    ){}

    #[Route('/1/{file}', name: 'day7_1', defaults: ["file"=>"day7"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $total = $this->day7services->updateGridWithTachyons($grid);

        return new JsonResponse($total, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day7_2', defaults: ["file"=>"day7"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $timelines = $this->day7services->countTimelines($grid);

        return new JsonResponse($timelines, Response::HTTP_OK);
    }
}
