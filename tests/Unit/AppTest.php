<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Application;
use App\Reader;
use App\Parser;
use App\Processor;

class AppTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    /**
     * Set up environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        $this->readerMock = $this->createMock(Reader::class);
        $this->parserMock = $this->createMock(Parser::class);
        $this->processorMock = $this->createMock(Processor::class);

        $this->parserMock->method('formatData')->willReturn(
            [
                'data' => [],
                'call_duration' => 233.45
            ]
        );

        $this->config = [
            'user_path' => 'user_data_file_path.txt',
            'customer_path' => 'customer_data_file_path.txt'
        ];

        $this->app = new Application(
            $this->readerMock,
            $this->parserMock,
            $this->processorMock,
            $this->config
        );
    }

    /**
     * Test prepearing data sequence
     * 
     * @return void
     */
    public function testPreparingData(): void
    {
        $this->readerMock
            ->expects($this->exactly(2))
            ->method('setPath')
            ->withConsecutive(
                [$this->config['user_path']],
                [$this->config['customer_path']]
            );

        $this->readerMock
            ->expects($this->exactly(2))
            ->method('readFile');

        $this->parserMock
            ->expects($this->exactly(2))
            ->method('formatData');

        $this->app->run();
    }

    /**
     * Test processing sequence
     * 
     * @return void
     */
    public function testProcess(): void
    {
        $this->processorMock
            ->expects($this->exactly(2))
            ->method('findLongestTalk');

        $this->processorMock
            ->expects($this->once())
            ->method('getCallDuration');

        $this->processorMock
            ->expects($this->once())
            ->method('findPercentageTalk');
                    
        $this->app->run();
    }

    /**
     * Test run - return all array keys
     * 
     * @return void
     */
    public function testRun(): void
    {
        $expected = [
            'longest_user_monologue',
            'longest_customer_monologue',
            'user_talk_percentage',
            'user',
            'customer'
        ];

        $result = $this->app->run();
        $resultKeys = array_keys($result);

        $this->assertSame($expected, $resultKeys);
    }

}
