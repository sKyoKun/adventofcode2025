<?php

namespace App\Services;

class Day9Services
{
    public function calculateAreas($lines): array
    {
        $areas = [];

        foreach ($lines as $key => $line) {
            for ($i = $key +1; $i < count($lines); $i++) {
                $areas[] = (abs($lines[$i][0] - $line[0]) +1) * (abs($lines[$i][1]- $line[1]) +1);
            }
        }

        return $areas;
    }
}
