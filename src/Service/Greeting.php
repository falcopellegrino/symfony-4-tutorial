<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 3/9/2019
 * Time: 2:48 PM
 */

namespace App\Service;

use Psr\Log\LoggerInterface;

class Greeting
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $message;

    public function __construct(
        LoggerInterface $logger,
        string $message
    ) {
        $this->logger = $logger;
        $this->message = $message;
    }

    public function greet(string $name): string
    {
        //$greetMessage = "Hello $name!";
        $greetMessage = "{$this->message} $name!";
        $this->logger->info($greetMessage);
        return $greetMessage;
    }
}