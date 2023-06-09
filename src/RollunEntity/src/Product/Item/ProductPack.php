<?php

declare(strict_types=1);

namespace rollun\Entity\Product\Item;

/**
 * Class ProductPack
 *
 * @author    r.ratsun <r.ratsun.rollun@gmail.com>
 *
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license   LICENSE.md New BSD License
 */
class ProductPack extends AbstractItem
{
    /**
     * @var Product
     */
    public Product $product;

    /**
     * @var int
     */
    public int $quantity;

    /**
     * ProductPack constructor.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @inheritDoc
     */
    public function getWeight(): float|int
    {
        return $this->product->getWeight() * $this->quantity;
    }

    /**
     * @inheritDoc
     */
    public function getDimensionsList(): array
    {
        return [['dimensions' => $this->product->dimensions, 'quantity' => $this->quantity]];
    }

    public function getDimensions(): array
    {
        $dimensions = [];
        for ($i = 0; $i < $this->getQuantity(); ++$i) {
            $dimensions[] = $this->product->dimensions;
        }
        return $dimensions;
    }

    /**
     * @inheritDoc
     */
    public function getVolume(): int
    {
        return $this->product->getVolume() * $this->quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
