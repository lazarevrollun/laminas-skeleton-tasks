<?php

/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace Unit\RollunEntity\Product\Container;

use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use Latuconsinafr\BinPackager\BinPackager3D\Packager as PackagerLib;
use PHPUnit\Framework\TestCase;
use rollun\Entity\Packer\PackagerEnvelope;
use rollun\Entity\Packer\PackagerInterface;
use rollun\Entity\Product\Container\ContainerAbstract;
use rollun\Entity\Product\Container\Envelope;
use rollun\Entity\Product\Dimensions\Rectangular;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Product\Item\ProductKit;
use rollun\Entity\Product\Item\ProductPack;

class PackagerEnvelopeTest extends TestCase
{
    public function getCanFitDataProvider(): array
    {
        return [
            // $box, $item, $expected
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(36, 24.5),
                new ProductPack(new Product(new Rectangular(13, 9, 4), 0.5), 6),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(8, 5, 4), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(14.5, 4.7, 4.7), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(14.5, 5.7, 3.7), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(14.5, 6.7, 2.7), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(14.5, 7.7, 1.7), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(14.5, 8.7, 0.7), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new Product(new Rectangular(14.5, 9.0, 0.4), 0.1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new ProductPack(new Product(new Rectangular(8, 5, 4), 0.5), 1),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new ProductKit([new Product(new Rectangular(8, 5, 4), 0.5)]),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new ProductKit([
                    new ProductPack(new Product(new Rectangular(8, 5, 4), 0.5), 1)
                ]),
                true
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(36, 24.5),
                new ProductKit([
                    new Product(new Rectangular(22, 14.5, 5.5), 0.1),
                    new Product(new Rectangular(13, 9, 4), 0.1),
                    new Product(new Rectangular(20.5, 14.5, 3), 0.1),
                ]),
                false
            ],
            [
                new PackagerEnvelope(new PackagerLib(2)),
                new Envelope(15, 9.5),
                new ProductKit([
                    new Product(new Rectangular(8, 5, 4), 0.1),
                ]),
                true
            ],

        ];
    }

    /**
     * @param Envelope $box
     * @param Rectangular $rectangular
     * @param bool $expected
     *
     * @throws \Exception
     * @dataProvider getCanFitDataProvider
     */
    public function testCanFit(PackagerInterface $packager, ContainerAbstract $box, ItemInterface $item, bool $expected)
    {
        $this->assertEquals($expected, $packager->canFit($box, $item));
    }
}
