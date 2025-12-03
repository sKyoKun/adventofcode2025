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
}
