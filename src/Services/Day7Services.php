<?php

namespace App\Services;

class Day7Services
{
    public function updateGridWithTachyons(array &$grid): int
    {
        $totalSplit = 0;

        // search the start and move first beam
        $startPos = array_search('S', $grid[0]);
        $grid[1][$startPos] = '|';

        for ($i = 2; $i < count($grid); $i++) {
            for ($j = 0; $j < count($grid[$i]); $j++) {
                if ($this->canDuplicateBeam($grid, $i, $j)) {
                    $grid[$i][$j-1] = '|';
                    $grid[$i][$j+1] = '|';
                    $totalSplit++;
                }
                if ($this->canMoveBeam($grid, $i, $j)) {
                    $grid[$i][$j] = '|';
                }
            }
        }

        return $totalSplit;
    }

    // @see https://fr.wikipedia.org/wiki/Triangle_de_Pascal
    public function countTimelines(array &$grid): int
    {
        $computedBeamPositions = [];
        $this->initializeComputedBeamPositions($grid, $computedBeamPositions);

        $startPos = array_search('S', $grid[0]);
        $computedBeamPositions[1][$startPos] = 1; // the first beam is right under the S

        for ($i = 2; $i < count($grid); $i++) {
            for ($j = 0; $j < count($grid[$i]); $j++) {
                if ('^' === $grid[$i][$j]) {
                    // when we encounter a ^ then the beam disappear (the count returns to 0)
                    $computedBeamPositions[$i][$j] = 0;
                    // both right and left get the previous beam counter as it splits (and it may have been already
                    // set by another ^ so we add the current value)
                    $computedBeamPositions[$i][$j-1] += $computedBeamPositions[$i-1][$j];
                    $computedBeamPositions[$i][$j+1] += $computedBeamPositions[$i-1][$j];
                }
                else {
                    // the beam continues so the value is the same
                    $computedBeamPositions[$i][$j] += $computedBeamPositions[$i-1][$j];
                }
            }
        }

        $lastLine = array_pop($computedBeamPositions);

        return array_sum($lastLine);
    }

    private function canDuplicateBeam(array $grid, int $i, int $j): bool
    {
        if ('^' === $grid[$i][$j] && '|' === $grid[$i-1][$j]) {
            return true;
        }

        return false;
    }

    private function canMoveBeam(array $grid, int $i, int $j): bool
    {
        if ('.' === $grid[$i][$j] && '|' === $grid[$i-1][$j]) {
            return true;
        }

        return false;
    }

    private function initializeComputedBeamPositions(array $grid, array &$computedBeamPositions): void
    {
        for ($i = 0; $i < count($grid); $i++) {
            for($j = 0; $j < count($grid[$i]); $j++) {
                $computedBeamPositions[$i][$j] = 0;
            }
        }
    }
}
