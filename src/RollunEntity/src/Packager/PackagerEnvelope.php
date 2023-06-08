<?php

namespace rollun\Entity\Packager;

use Exception;
use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use rollun\Entity\Product\Container\ContainerInterface;
use rollun\Entity\Product\Dimensions\Rectangular;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Product\Item\ProductKit;
use rollun\Entity\Product\Item\ProductPack;

class PackagerEnvelope implements PackagerInterface
{
    public function __construct(private Packager $libPackager)
    {
    }

    /**
     * @throws Exception
     */
    public function canFit(ContainerInterface $container, ItemInterface $item): bool
    {
        $class = get_class($item);
        return match ($class) {
            Product::class => $this->canFitProduct($container, $item),
            ProductPack::class => $this->canFitProductPack($container, $item),
            ProductKit::class => $this->canFitProductKit($container, $item),
            default => throw new Exception("Invalid class $class"),
        };
    }

    protected function canFitProduct(ContainerInterface $container, ItemInterface $item): bool
    {
        $dimensionsList = $item->getDimensionsList();
        $dimensions = $dimensionsList[0]['dimensions'];

        if (!($dimensions instanceof Rectangular) ||
            ($dimensions->max > $container->max - 0.5) ||
            ($dimensions->mid > $container->mid - 0.5)
        ) {
            return false;
        }
        $minPerimeter = ($dimensions->min + $dimensions->mid) * 2;
        return $minPerimeter < $container->mid * 2;
    }

    protected function canFitProductPack(ContainerInterface $container, ItemInterface $item): bool
    {
        $this->addInnerContainersToPackager($container);
        $this->packItemToEachContainer($item);
        $this->pack();
        return $this->isPacked();
    }

    protected function canFitProductKit(ContainerInterface $container, ItemInterface $item): bool
    {
        $this->addInnerContainersToPackager($container);
        $this->addProductKitToPackager($item);
        $this->pack();
        return $this->isPacked();
    }

    private function packItemToEachContainer(ItemInterface $item)
    {
        foreach ($this->libPackager->getBins() as $bin) {
            $dimensionsList = $item->getDimensionsList()[0];
            $dimensions = $dimensionsList['dimensions'];
            $quantity = $dimensionsList['quantity'];
            for ($i = 0; $i < $quantity; ++$i) {
                $this->libPackager->packItemToBin($bin, new Item("item-id-" . microtime(), $dimensions->max, $dimensions->min, $dimensions->mid, 5));
            }
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

    private function pack(): void
    {
        $this->libPackager->withFirstFit()->pack();
    }

    private function addInnerContainersToPackager(ContainerInterface $container): void
    {
        $innerContainers = $this->getEnvelopeInnerBoxes($container);
        foreach ($innerContainers as $key => $innerContainer) {
            $this->libPackager->addBin(
                new Bin(
                    "bin-$key", $innerContainer['length'], $innerContainer['height'], $innerContainer['width'], 9999
                )
            );
        }
    }

    private function packItemToBin(ItemInterface $item, $bin): void
    {
        $dimensionsList = $item->getDimensionsList()[0];
        $dimensions = $dimensionsList['dimensions'];
        $this->libPackager->packItemToBin($bin, new Item("item-id-" . microtime(), $dimensions->max, $dimensions->min, $dimensions->mid, 5));
    }

    private function addProductKitToPackager(ItemInterface $item): void
    {
        foreach ($this->libPackager->getBins() as $bin) {
            foreach ($item->items as $oneItem) {
                $quantity = $oneItem->getDimensionsList()[0]['quantity'];
                for ($i = 0; $i < $quantity; ++$i) {
                    $this->packItemToBin($item, $bin);
                }
            }
        }
    }

    protected function getEnvelopeInnerBoxes(ContainerInterface $container): array
    {
        $perimeter = ($container->mid * 2) * 0.97; // N% free space in real envelope
        $halfPerimeter = $perimeter / 2;
        return [
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.1, 'width' => $halfPerimeter * 0.9],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.15, 'width' => $halfPerimeter * 0.85],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.2, 'width' => $halfPerimeter * 0.8],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.25, 'width' => $halfPerimeter * 0.75],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.3, 'width' => $halfPerimeter * 0.7],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.35, 'width' => $halfPerimeter * 0.65],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.4, 'width' => $halfPerimeter * 0.6],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.45, 'width' => $halfPerimeter * 0.55],
            ['length' => $container->max - 0.5, 'height' => $halfPerimeter * 0.5, 'width' => $halfPerimeter * 0.5],
        ];
    }
}
