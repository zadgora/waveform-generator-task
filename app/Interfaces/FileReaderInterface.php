<?php

declare(strict_types=1);

namespace App\Interfaces;

interface FileReaderInterface
{
    /**
     * Set path
     * @param string $path
     * 
     * @return FileReaderInterface
     */
    public function setPath(string $path): self;

    /**
     * Read file
     * 
     * @return iterable
     */
    public function readFile(): iterable;
}