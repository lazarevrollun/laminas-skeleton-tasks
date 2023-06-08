<?php

namespace rollun\Entity\Packager;

use rollun\Entity\Product\Container\ContainerInterface;
use rollun\Entity\Product\Item\ItemInterface;

interface PackagerInterface
{
    function canFit(ContainerInterface $container, ItemInterface $item): bool;
}