<?php

declare(strict_types=1);

namespace Tests\ClassTest;

use PHPUnit\Framework\TestCase;
use App\Reader;
use App\Exceptions\FileNotFoundException;

class ReaderTest extends TestCase
{
    /**
     * @var string
     */
    private static $userPath;

    /**
     * @var string
     */
    private static $customerPath;

    /**
     * @var Reader
     */
    private static $reader;

    /**
     * Set up static environment before object created
     * 
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        define('DS', DIRECTORY_SEPARATOR);
        self::$userPath = __DIR__ . DS . '..' . DS . 'Files' . DS . 'testFileUser.txt';
        self::$customerPath = __DIR__ . DS . '..' . DS . 'Files' . DS . 'testFileCustomer.txt';
        self::$reader = new Reader();
    }

    /**
     * Test getter and setter
     * 
     * @return void
     */
    public function testGetterAndSetter(): void
    {
        $path = __DIR__.DS.'test-path.txt';
        self::$reader->setPath($path);
        $this->assertSame($path, self::$reader->getPath());
    }

    /**
     * Test data reading
     * 
     * @return void
     */
    public function testReadData(): void
    {
        self::$reader->setPath(self::$userPath);
        $this->assertIsIterable(self::$reader->readFile());
    }

    /**
     * Test user data is read correctly
     * 
     * @return void
     */
    public function testVerifyUserData(): void
    {
        $data = <<<HEREDOC
        [silencedetect @ 0x7fbfbbc076a0] silence_start: 3.504
        [silencedetect @ 0x7fbfbbc076a0] silence_end: 6.656 | silence_duration: 3.152
        HEREDOC;

        self::$reader->setPath(self::$userPath);
        $res = null;
        foreach (self::$reader->readFile() as $line) {
            $res .= $line;
        }
        $this->assertSame($data, $res);
    }

    /**
     * Test customer data is read correctly
     * 
     * @return void
     */
    public function testVerifyCustomerData(): void
    {
        $data = <<<HEREDOC
        [silencedetect @ 0x7fa7edd0c160] silence_start: 1.84
        [silencedetect @ 0x7fa7edd0c160] silence_end: 4.48 | silence_duration: 2.64
        HEREDOC;

        self::$reader->setPath(self::$customerPath);
        $res = null;
        foreach (self::$reader->readFile() as $line) {
            $res .= $line;
        }
        $this->assertSame($data, $res);
    }

    /**
     * Test FileNotFoundException is thrown
     * 
     * @return void
     */
    public function testConfirmFileNotFoundException(): void
    {
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage("File not found");

        $path  = __DIR__ . DS . "wrong-path.txt";
        self::$reader->setPath($path);
        $res = null;
        foreach (self::$reader->readFile() as $line) {
        }
    }
}
