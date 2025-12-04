<?php

namespace App\Services;

class Day3Services
{
    public function calculateLargestJoltage(array $bank) : int
    {
        $firstMax = max($bank);
        $firstKey = array_search($firstMax, $bank);
        // if the first value is on the last position, we search the first max on the array before
        if ($firstKey === count($bank)-1) {
            $newArray = array_slice($bank, 0, $firstKey);
            $secondMax = max($newArray);
            $joltage = (int) $secondMax.$firstMax;
        } else {
            $newArray = array_slice($bank, $firstKey+1);
            $secondMax = max($newArray);
            $joltage = (int) $firstMax.$secondMax;
        }

        return $joltage;
    }

    public function calculateLargestJoltagelamps(array $bank, int $toTurnOn = 12) : int
    {
        $joltage = '';
        $maxPos = -1;
        for ($i = $toTurnOn; $i > 0; $i--) {
            $max = 0;
            for ($j = $maxPos+1; $j <= count($bank)-$i; $j++) {
                if ($bank[$j] > $max) {
                    $max = $bank[$j];
                    $maxPos = $j;
                }
            }
            $joltage .= $max;
        }

        return (int) $joltage;
    }
}
