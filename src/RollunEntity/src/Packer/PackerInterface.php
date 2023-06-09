<?php

namespace rollun\Entity\Packer;

interface PackerInterface
{
    public function canFit(array $containers, array $productDimensions): bool;
}