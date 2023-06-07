<?php

declare(strict_types=1);

namespace rollun\Entity\Product\Container;

use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use Latuconsinafr\BinPackager\BinPackager3D\Types\SortType;
use rollun\Entity\Product\Item\ItemInterface;

/**
 * Class Box
 *
 * @author    r.ratsun <r.ratsun.rollun@gmail.com>
 *
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license   LICENSE.md New BSD License
 */
class Box extends ContainerAbstract
{
    /**
     * Container type
     */
    const TYPE_BOX = 'Box';

    /**
     * @var float
     */
    public $max;

    /**
     * @var float
     */
    public $mid;

    /**
     * @var float
     */
    public $min;

    /**
     * Box constructor.
     *
     * @param float $max
     * @param float $mid
     * @param float $min
     */
    public function __construct($max, $mid, $min)
    {
        $dim = compact('max', 'mid', 'min');
        rsort($dim, SORT_NUMERIC);
        [$this->max, $this->mid, $this->min] = $dim;
    }

    public function getType(): string
    {
        return static::TYPE_BOX;
    }

    /**
     * @inheritDoc
     */
    protected function canFitProduct(ItemInterface $item): bool
    {
        // get item dimensions
        $dimensions = $item->getDimensionsList()[0]['dimensions'];

        return $this->max >= $dimensions->max && $this->mid >= $dimensions->mid && $this->min >= $dimensions->min;
    }

    /**
     * @inheritDoc
     */
    protected function canFitProductPack(ItemInterface $item): bool
    {
        $packager = new Packager(2, SortType::DESCENDING);

        $packager->addBin(new Bin('bin', $this->max, $this->min, $this->mid, 9999));

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

    /**
     * @inheritDoc
     */
    protected function canFitProductKit(ItemInterface $item): bool
    {
        $packager = new Packager(2, SortType::DESCENDING);
        $packager->addBin(new Bin('bin', $this->max, $this->min, $this->mid, 9999));
        $i = 0;
        foreach ($item->items as $item) {
            $dimensionsList = $item->getDimensionsList()[0];
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
