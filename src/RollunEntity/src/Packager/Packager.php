<?php

namespace rollun\Entity\Packager;


use rollun\Entity\Product\Container\ContainerInterface;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Product\Item\ProductKit;
use rollun\Entity\Product\Item\ProductPack;

class Packager implements PackagerInterface
{
    public function __construct(private $libPackager)
    {
    }

    public function canFit(ItemInterface $item): bool
    {
        $class = get_class($item);
        return match ($class) {
            Product::class => $this->canFitProduct($item),
            ProductPack::class => Packager::canFitItemToContainer($this, $item),
            ProductKit::class => $this->canFitProductKit($item),
            default => throw new \Exception("Invalid class $class"),
        };
    }

    public function canFitItemToContainer($item, ContainerInterface $container): bool
    {
        var_dump($this->libPackager);
//
//        $packager->addBin(new Bin('bin', $this->max, $this->mid, $this->min, 9999));
//
//        for ($i = 0; $i < $item->getQuantity(); ++$i) {
//            $dimensions = $item->product->getDimensionsList()[0]['dimensions']->getDimensionsRecord();
//            $packager->addItem(new Item("item-id-$i", $dimensions['Length'], $dimensions['Height'], $dimensions['Width'], 5));
//        }
//
//        $packager->withFirstFit()->pack();
//        $bins = $packager->getBins();
//
//        $bin = iterator_to_array($bins)['bin'];
//        $unfittedItems = $bin->getUnfittedItems();
//
//        return !count($unfittedItems);
        return true;
    }
}