<?php

namespace App\Services;

class Day5Services
{
    public function parseDatabase(array $lines) : array {
        $emptyLine = array_search("", $lines);
        $rangeOfFreshIngredients = [];
        $availableIngredients = [];

        for ($i = 0; $i < $emptyLine; $i++) {
            $rangeOfFreshIngredients[] = $lines[$i];
        }
        for ($j = $emptyLine+1; $j < count($lines); $j++) {
            $availableIngredients[] = $lines[$j];
        }

        return [$rangeOfFreshIngredients, $availableIngredients];
    }

    public function determineUsableIngredients(array $freshIngredientsRanges, array $availableIngredients) : array
    {
        $usableIngredients = [];
        foreach ($availableIngredients as $availableIngredient) {
            foreach ($freshIngredientsRanges as $freshIngredientRange) {
                $rangeValues = explode('-', $freshIngredientRange);
                if (
                    ($availableIngredient >= $rangeValues[0] && $availableIngredient <= $rangeValues[1])
                    && false === in_array($availableIngredient, $usableIngredients)
                ) {
                    $usableIngredients[] = $availableIngredient;
                }
            }
        }

        return $usableIngredients;
    }

    public function countTotalFreshIngredientIds(array $freshIngredientsRanges) : int
    {
        $count = 0;
        $sortRanges = function ($a, $b)
        {
            $rangeA = explode('-', $a);
            $rangeB = explode('-', $b);

            return (int)$rangeA[0] <=> $rangeB[0];
        };

        usort($freshIngredientsRanges, $sortRanges);
        $newRanges = $this->getNewRangesWithoutOverlap($freshIngredientsRanges);
        foreach ($newRanges as $newRange) {
            $count += $newRange[1] - $newRange[0] +1;
        }

        return $count;
    }

    private function getNewRangesWithoutOverlap(array $freshIngredientsRanges) : array
    {
        $newRanges = [];
        $lastRange = [0,0];
        foreach ($freshIngredientsRanges as $freshIngredientRange) {
            $range = explode('-', $freshIngredientRange);
            // completely inside previous range
            if ((int)$range[0] < $lastRange[1] && (int)$range[1] < $lastRange[1]) {
                continue;
            }
            // overlap
            if ((int)$range[0] <= $lastRange[1] && (int)$range[1] >= $lastRange[1])
            {
                // if range is X-X, skip
                if ($lastRange[1]+1 === (int)$range[1]) {
                    continue;
                }
                $newRange = [$lastRange[1]+1, (int)$range[1]];
                $newRanges[] = $newRange;
                $lastRange = $newRange;
            } else { // brand new range
                $newRange = [(int)$range[0], (int)$range[1]];
                $newRanges[] = $newRange;
                $lastRange = $newRange;
            }
        }

        return $newRanges;
    }
}
