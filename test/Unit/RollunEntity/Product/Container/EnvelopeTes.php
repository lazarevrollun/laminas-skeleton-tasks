<?php

/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */
declare(strict_types=1);

namespace Unit\RollunEntity\Product\Container;

use Latuconsinafr\BinPackager\BinPackager3D\Bin;
use Latuconsinafr\BinPackager\BinPackager3D\Item;
use Latuconsinafr\BinPackager\BinPackager3D\Packager;
use Latuconsinafr\BinPackager\BinPackager3D\Types\SortType;
use PHPUnit\Framework\TestCase;
use rollun\Entity\Product\Container\ContainerAbstract;
use rollun\Entity\Product\Container\Envelope;
use rollun\Entity\Product\Dimensions\Rectangular;
use rollun\Entity\Product\Item\ItemInterface;
use rollun\Entity\Product\Item\Product;
use rollun\Entity\Product\Item\ProductKit;
use rollun\Entity\Product\Item\ProductPack;

class EnvelopeTest extends TestCase
{

    public function getCanFitDataProvider(): array
    {
        return [
            // $box, $item, $expected
            [new Envelope(15, 9.5), new Product(new Rectangular(8, 5, 4), 0.1), true],
            [new Envelope(15, 9.5), new Product(new Rectangular(14.5, 4.7, 4.7), 0.1), true],
            [new Envelope(15, 9.5), new Product(new Rectangular(14.5, 5.7, 3.7), 0.1), true],
            [new Envelope(15, 9.5), new Product(new Rectangular(14.5, 6.7, 2.7), 0.1), true],
            [new Envelope(15, 9.5), new Product(new Rectangular(14.5, 7.7, 1.7), 0.1), true],
            [new Envelope(15, 9.5), new Product(new Rectangular(14.5, 8.7, 0.7), 0.1), true],
            [new Envelope(15, 9.5), new Product(new Rectangular(14.5, 9.0, 0.4), 0.1), true],

//

            [new Envelope(15, 9.5),  new ProductPack(new Product(new Rectangular(8, 5, 4), 0.5), 1), true],

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
    public function testCanFit(ContainerAbstract $box, ItemInterface $item, bool $expected)
    {
        $this->assertEquals($expected, $box->canFit($item));
    }
//    public function testEnvelopeTrue()
//    {
//        $box = new Envelope(12.5, 9.5);
//        $rectangular = new Rectangular(8, 5, 4);
//        $product = new Product($rectangular, 0.5);
//
//        $this->assertEquals(true, $box->canFit($product));
//    }

//    public function testEnvelopeFalse()
//    {
//        $box = new Envelope(12.5, 9.5);
//
//        $rectangular = new Rectangular(8, 6, 5);
//        $product = new Product($rectangular, 0.5);
//
//        $this->assertEquals(false, $box->canFit($product));
//    }
//
//
//    public function cantFitRectangularDataProvider()
//    {
//        return [
//            [new Envelope(15, 9.5), new Rectangular(8, 7.5, 3.5)],
//            [new Envelope(15, 9.5), new Rectangular(4.75, 4.75, 4.75)]
//
//        ];
//    }
//
//    /**
//     * @dataProvider cantFitRectangularDataProvider
//     */
//    public function testEnvelopeCantFit(Envelope $box, Rectangular $rectangular)
//    {
//        //1.370, 8.00/3.50/7.50 --- Legal Flat Rate  ---где это 15" x 9 1/2" Картонный конверт
//        $product = new Product($rectangular, 1.370);
//        $this->assertEquals(false, $box->canFit($product));
//    }
//
//
//    public function fitRectangularDataProvider()
//    {
//        return [
//            [new Envelope(15, 9.5), new Rectangular(4, 4, 4)],
//            [new Envelope(15, 9.5), new Rectangular(4.5, 4.5, 4.5)]
//        ];
//    }
//
//    /**
//     * @dataProvider fitRectangularDataProvider
//     * @param Envelope $box
//     * @param Rectangular $rectangular
//     */
//    public function testEnvelopeCanFit(Envelope $box, Rectangular $rectangular): void
//    {
//        $product = new Product($rectangular, 1.370);
//        $this->assertEquals(true, $box->canFit($product));
//    }


}
