<?php

declare(strict_types=1);

use HelloExample\HelloExampleHandlerAbstractFactory;
use HelloExample\People\PeopleAbstractFactory;

return [
    'dependencies' => [
        'aliases' => [
        ],
        'invokables' => [
//            Ivan::class => Ivan::class,
        ],
        'factories' => [
        ],
        'abstract_factories' => [
            HelloExampleHandlerAbstractFactory::class,
            PeopleAbstractFactory::class,
        ],
    ],
    PeopleAbstractFactory::KEY => [
        'ivan' => [
            'name' => 'Ivan123',
            'class' => \HelloExample\People\People::class,
        ],
        'sergiy' => [
            'name' => 'Sergiy123',
            'class' => \HelloExample\People\People::class,
        ],
    ],
    HelloExampleHandlerAbstractFactory::KEY => [
        'ivan-service' => [
            HelloExampleHandlerAbstractFactory::KEY_NAME => 'ivan',
        ],
        'sergiy-service' => [
            HelloExampleHandlerAbstractFactory::KEY_NAME => 'sergiy',
        ],
    ],
];
