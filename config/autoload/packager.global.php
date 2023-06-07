<?php

declare(strict_types=1);

use Latuconsinafr\BinPackager\BinPackager3D\Packager as PackagerLib;
use rollun\Entity\Packager\Packager;
use rollun\Entity\Packager\PackagerBox;
use rollun\utils\Factory\AbstractServiceAbstractFactory;

return [
    AbstractServiceAbstractFactory::KEY => [
        PackagerLib::class => [
            AbstractServiceAbstractFactory::KEY_CLASS => PackagerLib::class,
            AbstractServiceAbstractFactory::KEY_DEPENDENCIES => [
                'presicion' => [
                    AbstractServiceAbstractFactory::KEY_TYPE => AbstractServiceAbstractFactory::TYPE_SIMPLE,
                    AbstractServiceAbstractFactory::KEY_VALUE => 2
                ],
            ],
        ],
        Packager::class => [
            AbstractServiceAbstractFactory::KEY_CLASS => Packager::class,
            AbstractServiceAbstractFactory::KEY_DEPENDENCIES => [
                'libPackager' => PackagerLib::class,
            ],
        ],
        PackagerBox::class => [
            AbstractServiceAbstractFactory::KEY_CLASS => PackagerBox::class,
            AbstractServiceAbstractFactory::KEY_DEPENDENCIES => [
                'libPackager' => PackagerLib::class,
            ],
        ]
    ],
];
