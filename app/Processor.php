<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\ProcessorInterface;

class Processor implements ProcessorInterface
{

    /**
     * Find the longest talk period
     * @param iterable $data
     * 
     * @return float
     */
    public function findLongestTalk(iterable &$data): float
    {
        $longest = 0;
        foreach ($data as $pair) {
            $currentLength = round($pair[1] - $pair[0], 3);            
            if ($currentLength > $longest) {
                $longest = $currentLength;
            }
        }
        return  $longest;
    }

    /**
     * Calculate percentage of talk time
     * @param iterable $data
     * @param float $callDuration
     * 
     * @return float
     */
    public function findPercentageTalk(iterable &$data, float $callDuration): float
    {
        $talkSpan = 0;
        foreach ($data as $pair) {
            $talkSpan += ($pair[1] - $pair[0]);
        }
        $percentageTalk = ($talkSpan * 100) / $callDuration;;
        return $percentageTalk;
    }

    /**
     * Take the bigger time as call duration
     * @param float $userEndTime
     * @param float $customerEndTime
     * 
     * @return float
     */
    public function getCallDuration(float $userEndTime, float $customerEndTime): float
    {
        return $userEndTime > $customerEndTime ? $userEndTime : $customerEndTime;
    }
}
