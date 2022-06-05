<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\ParserInterface;

class Parser implements ParserInterface
{
    /**
     * Parse string data and turn it into dataset
     * @param iterable $rawData
     * 
     * @return array
     */
    public function formatData(iterable $rawData): array
    {
        $couple = [0];
        $silenceDuration = [];
        $data = [];
        $callDuration = 0;

        foreach ($rawData as $line) {

            if (is_string($line) && strpos($line, 'silence_start') !== false) {

                $endSpeak = trim(explode(':', $line)[1]);
                $couple[] = floatval($endSpeak);
            }

            if (is_string($line) && strpos($line, 'silence_end') !== false) {
                
                $output = [];
                preg_match_all('/silence_end: ([\.0-9]*) \| silence_duration: ([0-9\.]*)/', $line, $output);

                $silenceDuration[] = floatval(trim($output[2][0]));                
                $couple[] = floatval(trim($output[1][0]));

                //take the last point time for call duration
                $callDuration = floatval(trim($output[1][0]));
            }

            if (count($couple) > 1) {
                $data[] = $couple;
                $couple = [];
            }
        }
        
        $res = [
            'silence_duration' => array_sum($silenceDuration),
            'data' => $data,
            'call_duration' => $callDuration
        ];
        return $res;
    }
}