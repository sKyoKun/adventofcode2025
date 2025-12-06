<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day6Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day6', name: 'day6')]
class Day6Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day6Services $day6services,
        private CalendarServices $calendarservices
    ){}

    #[Route('/1/{file}', name: 'day6_1', defaults: ["file"=>"day6"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $parsedInput = $this->calendarservices->parseInputFromStringsWithUnevenSpaceToArray($lines);
        $total = 0;
        $operandLine = count($parsedInput) - 1;
        for ($column = 0; $column < count($parsedInput[0]); $column++){
            $total += $this->day6services->calculateColumn($parsedInput, $column, $operandLine);
        }

        return new JsonResponse($total, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day6_2', defaults: ["file"=>"day6"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInputNotTrimmed($file.'.txt');
        $cephalopodsProblem = $this->day6services->parseCephalopodProblem($lines);
        $operands = $this->day6services->getOperandsPerProblem($lines);
        $total = $this->day6services->calculateRealProblem($cephalopodsProblem, $operands);

        return new JsonResponse($total, Response::HTTP_OK);
    }
}
