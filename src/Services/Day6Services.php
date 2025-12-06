<?php

namespace App\Services;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Day6Services
{
    public function calculateColumn(array $problems, int $column, int $operandLine): int
    {
        $expressionLanguage = new ExpressionLanguage();
        $operand = $problems[$operandLine][$column];

        $total = 0;
        if ('*' === $operand) {
            $total = 1;
        }

        for ($line = 0; $line < count($problems) - 1; $line++) { // do not process operand line
            $expression = $total.$operand.$problems[$line][$column];
            $total = $expressionLanguage->evaluate($expression);
        }

        return $total;
    }

    public function parseCephalopodProblem(array $input): array
    {
        $operandLine = count($input) - 1;

        $problemsStarts = [];
        $operands = str_split($input[$operandLine]);
        for($i = 0; $i < count($operands); ++$i) {
            if (' ' !== $operands[$i]) {
                $problemsStarts[] = $i;
            }
        }

        // retrieve line max length
        $maxLength = 0;
        for ($line = 0; $line < count($input) - 1; $line++) {// do not process operand line
            if (strlen($input[$line]) > $maxLength) {
                $maxLength = strlen($input[$line]);
            }
        }

        // retrieve numbers per problem per line
        $numbersPerProblem = [];
        for($line = 0; $line < $operandLine; ++$line) {
            for ($i = 0; $i < count($problemsStarts); ++$i) {
                $currentStart = $problemsStarts[$i];
                if (false === isset($problemsStarts[$i + 1])) {
                    $end = $maxLength;
                } else {
                    $end = (int)$problemsStarts[$i + 1] - 1;
                }
                $length = $end - $currentStart;
                $number = substr($input[$line], $currentStart, $length);
                $number = str_pad($number, $length, ' ');
                $numbersPerProblem[$currentStart][$line] = $number;
            }
        }

        // mutate numbers per columns and group per problem
        $reelNumbersPerProblem = [];
        foreach ($numbersPerProblem as $key => $problem) {
            for ($i = strlen($problem[0]) - 1; $i >= 0; $i--) {
                $newNumber = '';
                foreach ($problem as $number) {
                    $substr = trim(substr($number, $i, 1));
                    $newNumber .= $substr;
                }
                $reelNumbersPerProblem[$key][] = $newNumber;
            }

        }

        return $reelNumbersPerProblem;
    }

    public function calculateRealProblem(array $problems, array $operands): int
    {
        $expressionLanguage = new ExpressionLanguage();
        $total = 0;
        foreach ($problems as $key => $problem) {
            $problemTotal = 0;
            $operand = $operands[$key];
            if ('*' === $operand) {
                $problemTotal = 1;
            }
            for ($line = 0; $line < count($problem); $line++) {
                $expression = $problemTotal.$operand.$problem[$line];
                $problemTotal = $expressionLanguage->evaluate($expression);
            }
            $total += $problemTotal;
        }

        return $total;
    }

    public function getOperandsPerProblem(array $input) : array
    {
        $problemsStarts = [];
        $operandLine = count($input) - 1;

        $operands = str_split($input[$operandLine]);
        for($i = 0; $i < count($operands); ++$i) {
            if (' ' !== $operands[$i]) {
                $problemsStarts[$i] = $operands[$i];
            }
        }

        return $problemsStarts;
    }
}
