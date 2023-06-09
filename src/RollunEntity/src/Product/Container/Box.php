<?php

declare(strict_types=1);

namespace rollun\Entity\Product\Container;

use rollun\Entity\Product\Dimensions\Rectangular;

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
        parent::__construct();
    }

    public function getType(): string
    {
        return static::TYPE_BOX;
    }

    protected function getEnvelopeInnerBoxes(): array
    {
        return [
            new Rectangular($this->max, $this->mid, $this->min),
        ];
    }
}
