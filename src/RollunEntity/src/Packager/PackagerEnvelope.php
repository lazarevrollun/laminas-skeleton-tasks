<?php

namespace rollun\Entity\Packager;


use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use Latuconsinafr\BinPackager\BinPackager3D\Types\SortType;
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
        $perimeters = array_map(
            static function ($a, $b) {
                return ($a + $b) * 2;
            },
            [$dimensions->min, $dimensions->mid, $dimensions->max,],
            [$dimensions->mid, $dimensions->max, $dimensions->min,]
        );
        $canFitByPerimeter = array_reduce(
            $perimeters,
            function ($canFit, $perimeter) use ($container) {
                return $canFit || $perimeter < ($container->mid * 2);
            },
            false
        );

        return $canFitByPerimeter;
    }

    protected function canFitProductPack(ContainerInterface $container, ItemInterface $item): bool
    {
        $packager = $this->libPackager;

        $dimensionsList = $item->getDimensionsList()[0];
        $dimensions = $dimensionsList['dimensions'];
        $quantity = $dimensionsList['quantity'];


        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 4.7, 4.7, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 5.7, 3.7, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 5.2, 4.0, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 6.7, 2.7, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 6.4, 3, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 7.7, 1.7, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 8.7, 0.7, 9999));
        $packager->addBin(new Bin('bin' . rand(1, 999), 14.5, 9.0, 0.4, 9999));

        for ($i = 0; $i < $quantity; ++$i) {
            $packager->addItem(new Item("item-id-$i", $dimensions->max, $dimensions->min, $dimensions->mid, 5));
        }

        $packager->withFirstFit()->pack();
        $bins = $packager->getBins();

        $bins = iterator_to_array($bins);

        foreach ($bins as $bin) {
            if (!count($bin->getUnfittedItems())) {
                return true;
            }
        }
        return false;
    }

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

    protected function canFitProductKit(ContainerInterface $container, ItemInterface $item): bool
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

}