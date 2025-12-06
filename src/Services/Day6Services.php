<?php

namespace App\Services;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Day6Services
{
    public function calculateColumn(array $problems, int $column, int $operandLine): int
    {
        $total = 0;
        $operand = $problems[$operandLine][$column];
        if ('*' === $operand) {
            $total = 1;
        }
        $expressionLanguage = new ExpressionLanguage();

        for ($line = 0; $line < count($problems) - 1; $line++) { // do not process operand line
            $expression = $total.$operand.$problems[$line][$column];
            $total = $expressionLanguage->evaluate($expression);
        }

        return $total;
    }
}
