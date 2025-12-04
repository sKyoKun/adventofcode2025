<?php

namespace App\Services;

class Day4Services
{
    public const ROLL = '@';

    public function countAccessibleRolls(array &$grid): int
    {
        $accessibleRolls = 0;
        $newGrid = $grid;
        for ($y=0; $y<count($grid); $y++) {
            for ($x=0; $x<count($grid[$y]); $x++) {
                if (self::ROLL === $grid[$y][$x] && $this->isAccessibleRoll($y, $x, $grid)) {
                    $accessibleRolls++;
                    $newGrid[$y][$x] = ".";
                }
                echo $newGrid[$y][$x];
            }
            echo "\n";
        }

        echo "\n\n\n";

        $grid = $newGrid;

        return $accessibleRolls;
    }

    private function isAccessibleRoll(int $y, int $x, array $grid): bool
    {
        $hasRollTopLeft = (isset($grid[$y-1][$x-1]) && self::ROLL === $grid[$y-1][$x-1]) ? 1 : 0;
        $hasRollTop = (isset($grid[$y-1][$x]) && self::ROLL === $grid[$y-1][$x]) ? 1 : 0;
        $hasRollTopRight = (isset($grid[$y-1][$x+1]) && self::ROLL === $grid[$y-1][$x+1]) ? 1 : 0;

        $hasRollLeft = (isset($grid[$y][$x-1]) && self::ROLL === $grid[$y][$x-1]) ? 1 : 0;
        $hasRollRight = (isset($grid[$y][$x+1]) && self::ROLL === $grid[$y][$x+1]) ? 1 : 0;

        $hasRollBottomLeft = (isset($grid[$y+1][$x-1]) && self::ROLL === $grid[$y+1][$x-1]) ? 1 : 0;
        $hasRollBottom = (isset($grid[$y+1][$x]) && self::ROLL === $grid[$y+1][$x]) ? 1 : 0;
        $hasRollBottomRight = (isset($grid[$y+1][$x+1]) && self::ROLL === $grid[$y+1][$x+1]) ? 1 : 0;

        return ($hasRollTopLeft+$hasRollTop+$hasRollTopRight+$hasRollLeft+$hasRollRight+$hasRollBottomLeft+$hasRollBottom+$hasRollBottomRight) < 4;
    }
}
