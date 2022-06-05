<?php

declare(strict_types = 1);

namespace App\Exceptions;

class FileNotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'File not found';
}