<?php

namespace rollun\Entity\Packager;


use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use rollun\Entity\Product\Container\ContainerInterface;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Product\Item\ProductKit;
use rollun\Entity\Product\Item\ProductPack;

class PackagerBox implements PackagerInterface
{
    public function __construct(private Packager $libPackager)
    {
    }

    /**
     * @throws \Exception
     */
    public function canFit(ContainerInterface $container, ItemInterface $item): bool
    {
        $class = get_class($item);
        return match ($class) {
            Product::class => $this->canFitProduct($container, $item),
            ProductPack::class => $this->canFitProductPack($container, $item),
            ProductKit::class => $this->canFitProductKit($container, $item),
            default => throw new \Exception("Invalid class $class"),
        };
    }

    protected function canFitProduct(ContainerInterface $container, ItemInterface $item): bool
    {
        $dimensions = $item->getDimensionsList()[0]['dimensions'];
        return $container->max >= $dimensions->max && $container->mid >= $dimensions->mid && $container->min >= $dimensions->min;
    }

    protected function canFitProductPack(ContainerInterface $container, ItemInterface $item): bool
    {
        $packager = $this->libPackager;
        $packager->addBin(new Bin('bin', $container->max, $container->min, $container->mid, 9999));

        for ($i = 0; $i < $item->getQuantity(); ++$i) {
            $dimensions = $item->product->getDimensionsList()[0]['dimensions']->getDimensionsRecord();
            $packager->addItem(
                new Item("item-id-$i", $dimensions['Length'], $dimensions['Height'], $dimensions['Width'], 5)
            );
        }

        $packager->withFirstFit()->pack();
        $bins = $packager->getBins();

        $bin = iterator_to_array($bins)['bin'];
        $unfittedItems = $bin->getUnfittedItems();

        return !count($unfittedItems);
    }


    protected function canFitProductKit(ContainerInterface $container, ItemInterface $item): bool
    {
        $packager = $this->libPackager;
        $packager->addBin(new Bin('bin', $container->max, $container->min, $container->mid, 9999));
        $i = 0;
        foreach ($item->items as $oneItem) {
            $dimensionsList = $oneItem->getDimensionsList()[0];
            $quantity = $dimensionsList['quantity'];
            $dimensions = $dimensionsList['dimensions']->getDimensionsRecord();
            for ($j = 0; $j < $quantity; ++$j, ++$i) {
                $packager->addItem(
                    new Item("item-id-$i", $dimensions['Length'], $dimensions['Height'], $dimensions['Width'], 5)
                );
            }
        }
        $packager->withFirstFit()->pack();
        $bins = $packager->getBins();

        $bin = iterator_to_array($bins)['bin'];
        $unfittedItems = $bin->getUnfittedItems();

        return !count($unfittedItems);
    }
}