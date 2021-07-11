<?php

namespace Runroom\GildedRose\Tests;

use PHPUnit\Framework\TestCase;
use Runroom\GildedRose\Domain\Model\GildedRose;
use Runroom\GildedRose\Domain\Model\Item;

class GildedRoseTest extends TestCase
{
    /**
     * @test
     */
    public function itemsDegradeQuality(): void {
        $items = [Item::create('', 1, 5)];

  	$gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

        $this->assertEquals(4, $items[0]->getQuality());
    }

    /**
     * @test
     */
    public function itemsDegradeDoubleQualityOnceTheSellInDateHasPass(): void {
        $items = [Item::create('', -1, 5)];

        $gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

  	$this->assertEquals(3, $items[0]->getQuality());
    }

    /**
     * @test
     */
    public function itemsCannotHaveNegativeQuality(): void {
        $items = [Item::create('', 0, 0)];

        $gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

        $this->assertEquals(0, $items[0]->getQuality());
    }

    /**
     * @test
     */
    public function agedBrieIncreasesQualityOverTime(): void {
  	$items = [Item::create('Aged Brie', 0, 5)];

        $gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

  	$this->assertEquals(7, $items[0]->getQuality());
    }

    /**
     * @test
     */
    public function qualityCannotBeGreaterThan50(): void {
  	$items = [Item::create('Aged Brie', 0, 50)];

        $gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

  	$this->assertEquals(50, $items[0]->getQuality());
    }

    /**
     * @test
     */
    public function sulfurasDoesNotChange(): void {
  	$items = [Item::create('Sulfuras, Hand of Ragnaros', 10, 10)];

        $gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

  	$this->assertEquals(10, $items[0]->getSellIn());
  	$this->assertEquals(10, $items[0]->getQuality());
    }

    /**
     * @return array<string, array<int>>
     */
    public static function backstageRules(): array {
        return [
                'incr. 1 if sellIn > 10' => [11, 10, 11],
                'incr. 2 if 5 < sellIn <= 10 (max)' => [10, 10, 12],
                'incr. 2 if 5 < sellIn <= 10 (min)' => [6, 10, 12],
                'incr. 3 if 0 < sellIn <= 5 (max)' => [5, 10, 13],
                'incr. 3 if 0 < sellIn <= 5 (min)' => [1, 10, 13],
                'puts to 0 if sellIn <= 0 (max)' => [0, 10, 0],
                'puts to 0 if sellIn <= 0 (...)' => [-1, 10, 0],
        ];
    }

    /**
     * @dataProvider backstageRules
     * @test
     */
    public function backstageQualityIncreaseOverTimeWithCertainRules(int $sellIn, int $quality, int $expected): void {
  	$items = [Item::create('Backstage passes to a TAFKAL80ETC concert', $sellIn, $quality)];

        $gilded_rose = new GildedRose($items);
        $gilded_rose->updateQuality();

  	$this->assertEquals($expected, $items[0]->getQuality());
    }
}
