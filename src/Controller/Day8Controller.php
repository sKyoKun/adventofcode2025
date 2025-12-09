<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day8Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day8', name: 'day8')]
class Day8Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day8Services $day8services,
        private CalendarServices $calendarservices,
    ){}

    #[Route('/1/{file}', name: 'day8_1', defaults: ["file"=>"day8"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $boxesCoordinates = $this->calendarservices->parseInputWithComma($lines);
        $distances = $this->day8services->calculateDistances($boxesCoordinates);
        $circuits = $this->day8services->organizeCircuits($distances, 1000);
        $countFirstCircuit = count(array_shift($circuits));
        $countSecondCircuit = count(array_shift($circuits));
        $countThirdCircuit = count(array_shift($circuits));

        return new JsonResponse($countFirstCircuit*$countSecondCircuit*$countThirdCircuit, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day8_2', defaults: ["file"=>"day8"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
