<?php

namespace App\Services;

class Day8Services
{
    public function calculateDistances(array $boxesCoordinates): array
    {
        $distances = [];

        for ($i = 0; $i < count($boxesCoordinates); $i++) {
            for ($j = $i+1; $j < count($boxesCoordinates); $j++) {
                $distances[] = [$this->calculateDistance($boxesCoordinates[$i], $boxesCoordinates[$j]) => [$i, $j]];
            }
        }

        uasort($distances, function ($a, $b) {
            return key($a) <=> key($b);
        }
        );

        return $distances;
    }

    public function organizeCircuits(array $distances, int $iterations = 10)
    {
        $circuits = [];
        $currentIteration = 0;
        while($currentIteration < $iterations && count($distances) > 0) {
            $firstDistance = array_shift($distances);
            $lines = array_shift($firstDistance);
            $found = null;
            foreach ($circuits as $key => $circuit) {
                if (in_array($lines[0], $circuit) || in_array($lines[1], $circuit)) {
                    $found = $key;
                    break;
                }
            }
            $this->updateCircuits($circuits, $lines, $found);

            $currentIteration++;
        }

        // sort circuit by number of boxes
        uasort($circuits, function ($a, $b) {
            return count($b) <=> count($a);
        }
        );

        return $circuits;
    }

    public function connectToOneBigCircuit(array $distances, array $boxesCoordinates)
    {
        $circuits = [];
        $shouldContinue = true;
        $xJunction = 0;
        $coordinatesInCircuits = $boxesCoordinates;
        while($shouldContinue && count($coordinatesInCircuits) >= 0) {
            $firstDistance = array_shift($distances);
            $lines = array_shift($firstDistance);
            $found = null;
            foreach ($circuits as $key => $circuit) {
                if (in_array($lines[0], $circuit) || in_array($lines[1], $circuit)) {
                    $found = $key;
                    unset($coordinatesInCircuits[$lines[0]]);
                    unset($coordinatesInCircuits[$lines[1]]);
                    break;
                }
            }

            $this->updateCircuits($circuits, $lines, $found);

            // all coordinates
            if (count($coordinatesInCircuits) > 0) {
                $shouldContinue = true;
            } else {
                if (count($circuits) === 1) {
                    $xJunction = $this->getXValueOfLine($lines[0], $boxesCoordinates) * $this->getXValueOfLine(
                            $lines[1],
                            $boxesCoordinates
                        );
                    $shouldContinue = false;
                }
            }
        }

        return $xJunction;
    }

    private function calculateDistance(array $firstCoordinates, array $secondCoordinates): float
    {
        $firstDistance = pow(($secondCoordinates[0] - $firstCoordinates[0]), 2);
        $secondDistance = pow(($secondCoordinates[1] - $firstCoordinates[1]), 2);
        $thirdDistance = pow(($secondCoordinates[2] - $firstCoordinates[2]), 2);
        $sumDistance = $firstDistance + $secondDistance + $thirdDistance;

        return sqrt($sumDistance);
    }

    private function getXValueOfLine(int $lineNumber, array $boxesCoordinates): int
    {
        return $boxesCoordinates[$lineNumber][0];
    }

    private function updateCircuits(array &$circuits, array $lines, ?int $found)
    {
        if (null === $found) {
            $circuits[] = [$lines[0], $lines[1]];
        } else {
            $circuits[$found] = array_unique(array_merge($circuits[$found], $lines));

            $keyOtherCircuit = null;
            // Search for another circuit with the same lines
            foreach ($circuits as $key => $circuit) {
                if ($key !== $found && array_intersect($lines, $circuit)) {
                    $keyOtherCircuit = $key;
                    break;
                }
            }
            //  If a line is in 2 circuits, we need to merge them ! And delete the other circuit
            if ($keyOtherCircuit !== null) {
                $circuits[$found] = array_unique(array_merge($circuits[$keyOtherCircuit], $circuits[$found]));
                unset($circuits[$keyOtherCircuit]);
            }
        }
    }
}
