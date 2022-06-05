<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ProcessorInterface
{
    /**
     * Find the logeset period
     * @param iterable $data
     * 
     * @return float
     */
    public function findLongestTalk(iterable &$data): float;

    /**
     * Calcuate percent of talk time
     * @param iterable $data
     * @param float $callDuration
     * 
     * @return float
     */
    public function findPercentageTalk(iterable &$data, float $callDuration): float;

    /**
     * Get the bigger time as final conversation duration
     * @param float $userEndTime
     * @param float $customerEndTime
     * 
     * @return float
     */
    public function getCallDuration(float $userEndTime, float $customerEndTime): float;
}