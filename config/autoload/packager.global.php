<?php

declare(strict_types=1);

use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use rollun\Entity\Packer\Packer;
use rollun\utils\Factory\AbstractAbstractFactory;
use rollun\utils\Factory\AbstractServiceAbstractFactory;

return [
    AbstractServiceAbstractFactory::KEY => [
        Packer::class => [
            AbstractServiceAbstractFactory::KEY_CLASS => Packer::class,
            AbstractServiceAbstractFactory::KEY_DEPENDENCIES => [
                'libPackager' => Packager::class,
            ],
        ],
        Packager::class => [
            AbstractAbstractFactory::KEY_CLASS => Packager::class,
            AbstractServiceAbstractFactory::KEY_DEPENDENCIES => [
                'precision' => [
                    AbstractServiceAbstractFactory::KEY_TYPE => AbstractServiceAbstractFactory::TYPE_SIMPLE,
                    AbstractServiceAbstractFactory::KEY_VALUE => 2
                ],
            ],
        ],
    ],
];
