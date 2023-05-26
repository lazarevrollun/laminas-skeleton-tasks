<?php

namespace HelloExample;

use HelloExample\People\PeopleInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HelloExampleHandler implements RequestHandlerInterface
{
    public function __construct(private PeopleInterface $people) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse("Hello ".$this->people->getName());
    }
}