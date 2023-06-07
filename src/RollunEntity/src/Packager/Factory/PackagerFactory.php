<?php

namespace rollun\Entity\Packager\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use rollun\Entity\Packager\Packager;

class PackagerFactory implements FactoryInterface
{
    public const KEY = self::class;

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Packager
    {
        $packager = $container->get('packager');
        return new Packager($packager);
    }
}