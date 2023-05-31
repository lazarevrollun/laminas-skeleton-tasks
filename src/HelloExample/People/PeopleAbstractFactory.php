<?php

namespace HelloExample\People;

use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;

class PeopleAbstractFactory implements AbstractFactoryInterface
{
    public const KEY = self::class;

    public const KEY_NAME = 'name';

    public const KEY_CLASS = 'class';

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): PeopleInterface
    {
        $config = $container->get('config');
        $serviceConfig = $config[self::KEY][$requestedName];
        $peopleName = $serviceConfig[self::KEY_NAME];
        $peopleClass = $serviceConfig[self::KEY_CLASS];
        return new $peopleClass($peopleName);
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