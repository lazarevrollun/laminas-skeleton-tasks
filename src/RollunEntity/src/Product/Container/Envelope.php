<?php

/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace rollun\Entity\Product\Container;

use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use Latuconsinafr\BinPackager\BinPackager3D\Types\SortType;
use rollun\Entity\Product\Container\ContainerAbstract;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Dimensions\Rectangular;

class Envelope extends ContainerAbstract
{

    const TYPE_ENVELOPE = 'Envelope';

    public $max;
    public $mid;

    public function __construct($max, $mid, $min = 0)
    {
        $dim = compact('max', 'mid');
        rsort($dim, SORT_NUMERIC);
        list($this->max, $this->mid) = $dim;
    }

    public function getType(): string
    {
        return static::TYPE_ENVELOPE;
    }

//    public function canFit(ItemInterface $item): bool
//    {
//        $dimensionsList = $item->getDimensionsList();
//        $dimensions = $dimensionsList[0]['dimensions'];
//
//        if (!($dimensions instanceof Rectangular) ||
//            ($dimensions->max > $this->max - 0.5) ||
//            ($dimensions->mid > $this->mid - 0.5)
//        ) {
//            return false;
//        }
//        $perimeters =  array_map(
//            static function ($a, $b) {
//                return ($a + $b) * 2;
//            },
//            [$dimensions->min, $dimensions->mid, $dimensions->max,],
//            [$dimensions->mid, $dimensions->max, $dimensions->min,]
//        );
//        $canFitByPerimeter = array_reduce(
//            $perimeters,
//             function ($canFit, $perimeter) {
//                return $canFit || $perimeter < ($this->mid * 2);
//            },
//            false
//        );
//
//
//        return $canFitByPerimeter;
//    }

    protected function canFitProduct(ItemInterface $item): bool
    {
        $dimensionsList = $item->getDimensionsList();
        $dimensions = $dimensionsList[0]['dimensions'];

        if (!($dimensions instanceof Rectangular) ||
            ($dimensions->max > $this->max - 0.5) ||
            ($dimensions->mid > $this->mid - 0.5)
        ) {
            return false;
        }
        $perimeters =  array_map(
            static function ($a, $b) {
                return ($a + $b) * 2;
            },
            [$dimensions->min, $dimensions->mid, $dimensions->max,],
            [$dimensions->mid, $dimensions->max, $dimensions->min,]
        );
        $canFitByPerimeter = array_reduce(
            $perimeters,
            function ($canFit, $perimeter) {
                return $canFit || $perimeter < ($this->mid * 2);
            },
            false
        );


        return $canFitByPerimeter;
//        $dimensionsList = $item->getDimensionsList();
//        $dimensions = $dimensionsList[0]['dimensions'];
//
//        if (!($dimensions instanceof Rectangular) ||
//            ($dimensions->max > $this->max - 0.5) ||
//            ($dimensions->mid > $this->mid - 0.5)
//        ) {
//            return false;
//        }
//        $minPerimeter = ($dimensions->min + $dimensions->mid) * 2;
//        return $minPerimeter < $this->mid * 2;

    }

    protected function canFitProductPack(ItemInterface $item): bool
    {
        $dimensionsList = $item->getDimensionsList();
        $dimensions = $dimensionsList[0]['dimensions'];

        if (!($dimensions instanceof Rectangular) ||
            ($dimensions->max > $this->max - 0.5) ||
            ($dimensions->mid > $this->mid - 0.5)
        ) {
            return false;
        }
        $perimeters =  array_map(
            static function ($a, $b) {
                return ($a + $b) * 2;
            },
            [$dimensions->min, $dimensions->mid, $dimensions->max,],
            [$dimensions->mid, $dimensions->max, $dimensions->min,]
        );
        $canFitByPerimeter = array_reduce(
            $perimeters,
            function ($canFit, $perimeter) {
                return $canFit || $perimeter < ($this->mid * 2);
            },
            false
        );


        return $canFitByPerimeter;
    }

    protected function canFitProductKit(ItemInterface $item): bool
    {
        return false;
    }
}
