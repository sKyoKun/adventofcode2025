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
}
