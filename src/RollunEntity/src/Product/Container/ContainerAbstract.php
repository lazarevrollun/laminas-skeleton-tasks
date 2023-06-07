<?php

declare(strict_types=1);

namespace rollun\Entity\Product\Container;

use rollun\Entity\Packager\Packager;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Product\Item\ProductKit;
use rollun\Entity\Product\Item\ProductPack;

/**
 * Class ContainerAbstract
 *
 * @author    r.ratsun <r.ratsun.rollun@gmail.com>
 *
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license   LICENSE.md New BSD License
 */
abstract class ContainerAbstract implements ContainerInterface
{
    /**
     * @param ItemInterface $item
     *
     * @return bool
     * @throws \Exception
     */
    public function canFit(ItemInterface $item): bool
    {
        $class = get_class($item);
        return match ($class) {
            Product::class => $this->canFitProduct($item),
            ProductPack::class => $this->canFitProductPack($item),
            ProductKit::class => $this->canFitProductKit($item),
            default => throw new \Exception("Invalid class $class"),
        };
    }

    /**
     * @return float
     */
    public function getContainerWeight(): float
    {
        return 0.0;
    }

    /**
     * @param ItemInterface $item
     *
     * @return bool
     */
    protected function canFitProduct(ItemInterface $item): bool
    {
        return false;
    }

    /**
     * @param ItemInterface $item
     *
     * @return bool
     */
    protected function canFitProductPack(ItemInterface $item): bool
    {
        return false;
    }

    /**
     * @param ItemInterface $item
     *
     * @return bool
     */
    protected function canFitProductKit(ItemInterface $item): bool
    {
        return false;
    }
}
