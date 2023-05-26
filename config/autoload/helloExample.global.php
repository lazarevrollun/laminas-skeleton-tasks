<?php

declare(strict_types=1);

use HelloExample\HelloExampleHandlerAbstractFactory;
use HelloExample\People\Ivan;
use HelloExample\People\PeopleAbstractFactory;
use HelloExample\People\Sergiy;

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
        Ivan::class => [
            'name' => 'Ivan123'
        ],
        Sergiy::class => [
            'name' => 'Sergiy'
        ],
    ],
    HelloExampleHandlerAbstractFactory::KEY => [
        'ivan' => [
            HelloExampleHandlerAbstractFactory::KEY_NAME => Ivan::class,
        ],
        'sergiy' => [
            HelloExampleHandlerAbstractFactory::KEY_NAME => Sergiy::class,
        ],
    ],
];
