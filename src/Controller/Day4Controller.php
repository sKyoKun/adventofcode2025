<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day4Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day4', name: 'day4')]
class Day4Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day4Services $day4services,
        private CalendarServices $calendarServices
    ){}

    #[Route('/1/{file}', name: 'day4_1', defaults: ["file"=>"day4"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $accessibleRolls = $this->day4services->countAccessibleRolls($grid);

        return new JsonResponse($accessibleRolls, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day4_2', defaults: ["file"=>"day4"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $accessibleRolls = 0;
        do {
            $rolls = $this->day4services->countAccessibleRolls($grid);
            $accessibleRolls += $rolls;
        } while ($rolls > 0);

        return new JsonResponse($accessibleRolls, Response::HTTP_OK);
    }
}
