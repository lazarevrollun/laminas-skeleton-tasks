<?php

namespace rollun\Entity\Packer;

use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager as PackagerLib;
use rollun\Entity\Product\Dimensions\DimensionsInterface;

class Packer implements PackerInterface
{
    public function __construct(private PackagerLib $libPackager)
    {
    }

    public function canFit(array $containers, array $productDimensions): bool
    {
        $this->addContainers($containers);
        $this->addItemToEachContainer($productDimensions);
        return $this->isPacked();
    }


    private function isItemPackedInContainer($productDimensions, mixed $container): bool
    {
        $this->addContainerToPackager($container);
        $this->addItemsToPackager($productDimensions);
        return $this->isPacked();
    }

    private function addContainerToPackager(DimensionsInterface $container): void
    {
        $this->libPackager->addBin(new Bin('bin-' . microtime(), $container->max, $container->min, $container->mid, 9999));
    }

    private function addItemsToPackager($productDimensions): void
    {
        foreach ($productDimensions as $dimensions) {
            $this->libPackager->addItem(new Item("item-id-" . microtime(), $dimensions->max, $dimensions->min, $dimensions->mid, 5));
        }
    }

    private function isPacked(): bool
    {
        $bins = $this->libPackager->getBins();
        foreach ($bins as $bin) {
            if (!count($bin->getUnfittedItems())) {
                return true;
            }
        }
        return false;
    }

    private function addContainers(array $containers)
    {
        foreach ($containers as $key => $container) {
            $this->libPackager->addBin(
                new Bin(
                    "bin-$key", $container->max, $container->min, $container->mid, 9999
                )
            );
        }
    }


    private function addItemToEachContainer(array $productDimensions)
    {
        foreach ($this->libPackager->getBins() as $bin) {
            foreach ($productDimensions as $productDimension)
            {
                $this->libPackager->packItemToBin($bin, new Item("item-id-" . microtime(), $productDimension->max, $productDimension->min, $productDimension->mid, 5));
            }
        }
    }
}