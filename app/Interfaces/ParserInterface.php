<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ParserInterface
{
    /**
     * Format data
     * @param iterable $data
     * 
     * @return array
     */
    public function formatData(iterable $data): array;
}