<?php

namespace HelloExample;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;

class HelloExampleHandlerAbstractFactory implements AbstractFactoryInterface
{
    public const KEY = self::class;

    public const KEY_NAME = 'name';

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config');

        if (!isset($config[self::KEY])) {
            return false;
        }

        $servicesConfig = $config[self::KEY];
        return is_array($servicesConfig) && array_key_exists($requestedName, $servicesConfig);
    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');

        if (!isset($config[self::KEY][$requestedName])) {
            throw new ServiceNotCreatedException("Can't find config");
        }

        $serviceConfig = $config[self::KEY][$requestedName];

        if (!isset($serviceConfig[self::KEY_NAME], $serviceConfig[self::KEY_NAME])) {
            throw new ServiceNotCreatedException("Required config key is missing");
        }

        $people = $container->get($serviceConfig[self::KEY_NAME]);

        return new HelloExampleHandler($people);
    }
}