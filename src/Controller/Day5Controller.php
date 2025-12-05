<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day5Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day5', name: 'day5')]
class Day5Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day5Services $day5services
    ){}

    #[Route('/1/{file}', name: 'day5_1', defaults: ["file"=>"day5"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        [$freshIngredientsRanges, $availableIngredients] = $this->day5services->parseDatabase($lines);
        $usableIngredients = $this->day5services->determineUsableIngredients($freshIngredientsRanges, $availableIngredients);

        return new JsonResponse(count($usableIngredients), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day5_2', defaults: ["file"=>"day5"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        [$freshIngredientsRanges, $availableIngredients] = $this->day5services->parseDatabase($lines);
        $total = $this->day5services->countTotalFreshIngredientIds($freshIngredientsRanges);

        return new JsonResponse($total, Response::HTTP_OK);
    }
}
