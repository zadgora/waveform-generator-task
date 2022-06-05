<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\FileReaderInterface;
use App\Interfaces\ParserInterface;
use App\Interfaces\ProcessorInterface;

class Application
{
    /**
     * @var FileReaderInterface
     */
    private $reader;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $userData = [];

    /**
     * @var array
     */
    private $customerData = [];

    /**
     * @var array
     */
    private $result = [];

    /**
     * @param FileReaderInterface $reader
     * @param ParserInterface $parser
     * @param ProcessorInterface $processor
     */
    public function __construct(
        FileReaderInterface $reader,
        ParserInterface $parser,
        ProcessorInterface $processor,
        array $config
    ) {
        $this->reader = $reader;
        $this->parser = $parser;
        $this->processor = $processor;
        $this->config = $config;
    }

    /**
     * Get user parsed data
     * 
     * @return array
     */
    public function getUserData(): array
    {
        return $this->userData;
    }

    /**
     * Get customer parsed data
     * 
     * @return array
     */
    public function getCustomerData(): array
    {
        return $this->customerData;
    }

    /**
     * Run the application sequence and return result
     * 
     * @return array
     */
    public function run(): array
    {
        //preapare user data
        $this->userData = $this->prepareData(
            $this->config['user_path']
        );
        //prepare customer data
        $this->customerData = $this->prepareData(
            $this->config['customer_path']
        );

        $this->process();
        return $this->result;
    }

    /**
     * Start processing sequence and format the result
     * 
     * @return void
     */
    private function process(): void
    {
        $userLongestTalk = $this->processor->findLongestTalk($this->userData['data']);
        $customerLongestTalk = $this->processor->findLongestTalk($this->customerData['data']);

        $callDuration = $this->processor->getCallDuration(
            $this->userData['call_duration'],
            $this->customerData['call_duration']
        );
        $percentageTalk = $this->processor->findPercentageTalk($this->userData['data'], $callDuration);

        $this->result = [
            'longest_user_monologue' => $userLongestTalk,
            'longest_customer_monologue' => $customerLongestTalk,
            'user_talk_percentage' => round($percentageTalk, 2),
            'user' => $this->userData['data'],
            'customer' => $this->customerData['data']
        ];
    }

    /**
     * Load raw data
     * @param string $path
     * 
     * @return array
     */
    private function prepareData($path): array
    {
        $this->reader->setPath($path);
        $rawData = $this->reader->readFile();
        return $this->parser->formatData($rawData);
    }
}
