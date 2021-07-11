<?php

namespace Runroom\GildedRose\Domain\Model;

class Item {

    protected int $sellIn;
    protected int $quality;

    public function __construct(int $sellIn, int $quality) {
        $this->sellIn = $sellIn;
        $this->quality = $quality;
    }
    
    public static function create(string $name, int $sellIn, int $quality): Item {
        switch($name) {
            case 'Aged Brie': return new AgedBrie($sellIn, $quality);
            case 'Backstage passes to a TAFKAL80ETC concert': return new BackstagePass($sellIn, $quality);
            case 'Sulfuras, Hand of Ragnaros': return new Sulfuras($sellIn, $quality);
            default: return new Item($sellIn, $quality);
        }
        
    }
    
    public function getSellIn(): int {
        return $this->sellIn;
    }

    public function getQuality(): int {
        return $this->quality;
    }

    public function setSellIn(int $sellIn): void {
        $this->sellIn = $sellIn;
    }

    public function setQuality(int $quality): void {
        $this->quality = $quality;
    }
      
    
    public function updateQuality(): void {
        if ($this->quality > 0) {
        $this->quality -= 1;
        }
        $this->sellIn -= 1;
        if ($this->sellIn < 0 && $this->quality > 0) {
            $this->quality -= 1;
        }
    }

}
