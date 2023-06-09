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
        parent::__construct();
    }

    public function getType(): string
    {
        return static::TYPE_ENVELOPE;
    }

    protected function getEnvelopeInnerBoxes(): array
    {
        $perimeter = ($this->mid * 2) * 0.97; // N% free space in real envelope
        $halfPerimeter = $perimeter / 2;
        return [
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.1,$halfPerimeter * 0.9),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.15,$halfPerimeter * 0.85),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.2,$halfPerimeter * 0.8),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.25,$halfPerimeter * 0.75),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.3,$halfPerimeter * 0.7),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.35,$halfPerimeter * 0.65),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.4,$halfPerimeter * 0.60),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.45,$halfPerimeter * 0.55),
            new Rectangular($this->max - 0.5, $halfPerimeter * 0.5,$halfPerimeter * 0.5),
        ];
    }
}
