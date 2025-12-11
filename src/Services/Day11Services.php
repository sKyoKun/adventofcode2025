<?php

namespace App\Services;

class Day11Services
{
    private const OUT = 'out';

    public function parseLines(array $lines): array
    {
        $devicesAndOutputs = [];
        foreach ($lines as $line) {
            $keyValues = explode(':', $line);
            $device = $keyValues[0];
            $outputs = explode(' ', trim($keyValues[1]));
            $devicesAndOutputs[$device] = $outputs;
        }

        return $devicesAndOutputs;
    }

    public function testDevicesOutputs(array $devicesAndOutputs, array $currentDevicesOutputs, array &$passedDevices, int &$paths): void
    {
        $diffBetweenPassedAndPossible = array_diff(array_values($currentDevicesOutputs), $passedDevices);
        $currentPassedDevices = $passedDevices;
       // dump($diffBetweenPassedAndPossible);
        while (count($diffBetweenPassedAndPossible) > 0) {
            $connectedDevice = array_shift($diffBetweenPassedAndPossible);
            //dump($connectedDevice);
            if (self::OUT === $connectedDevice) {
                $paths++;
            } else {
                if (false === in_array($connectedDevice, $passedDevices)) {
                    //var_dump($connectedDevice, $passedDevices);
                    $currentPassedDevices[] = $connectedDevice;
                    $this->testDevicesOutputs($devicesAndOutputs, $devicesAndOutputs[$connectedDevice], $currentPassedDevices, $paths);
                }
            }
        }
    }
}
