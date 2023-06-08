<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class MyHandler implements RequestHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private                 $multiplexer
    )
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        call_user_func($this->multiplexer);
        $this->logger->notice("Привіт світ!");
        return new HtmlResponse("Done");
    }
}
