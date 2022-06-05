<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\FileNotFoundException;
use App\Interfaces\FileReaderInterface;

class Reader implements FileReaderInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * Set file path variable
     * @param string $path
     * 
     * @return FileReaderInterface
     */
    public function setPath(string $path): FileReaderInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get file path
     * 
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Read file
     * @throws FileNotFoundException if file not found
     * 
     * @return iterable
     */
    public function readFile(): iterable
    {
        if (!file_exists($this->path)) {
            throw new FileNotFoundException();
        }
        $handle = fopen($this->path, "r");
        while (!feof($handle)) {
            yield fgets($handle);
        }
        fclose($handle);
    }
}
