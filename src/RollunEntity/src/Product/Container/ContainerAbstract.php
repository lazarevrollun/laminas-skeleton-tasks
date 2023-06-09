<?php

declare(strict_types=1);

namespace rollun\Entity\Product\Container;

use rollun\dic\InsideConstruct;
use rollun\Entity\Packer\Packer;
use rollun\Entity\Product\Item\ItemInterface;

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
    public function __construct(protected ?Packer $packer = null)
    {
        InsideConstruct::setConstructParams(['packer' => Packer::class]);
    }

    /**
     * @param ItemInterface $item
     *
     * @return bool
     * @throws \Exception
     */
    public function canFit(ItemInterface $item): bool
    {
        $innerContainers = $this->getEnvelopeInnerBoxes();
        $dimensionsArray = $item->getDimensions();
        return $this->packer->canFit($innerContainers, $dimensionsArray);
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
