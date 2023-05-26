<?php

namespace HelloExample\People;

use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;

class PeopleAbstractFactory implements AbstractFactoryInterface
{
    public const KEY = self::class;

    public const KEY_NAME = 'name';

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): PeopleInterface
    {
        $config = $container->get('config');
        $a = $config[self::KEY];
        $serviceConfig = $config[self::KEY][$requestedName];
        $name = $serviceConfig[self::KEY_NAME];
        return new $requestedName();
    }

    public function canCreate(ContainerInterface $container, $requestedName)
    {

        $config = $container->get('config');

        if (!isset($config[self::KEY])) {
            return false;
        }

        $servicesConfig = $config[self::KEY];
        return is_array($servicesConfig) && array_key_exists($requestedName, $servicesConfig);
    }
}