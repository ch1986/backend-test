<?php

namespace Runroom\GildedRose\Domain\Model;

class AgedBrie extends Item {
    
    public function updateQuality(): void {
        $this->sellIn -= 1;
        $this->quality += 1;

        if ($this->sellIn <= 0) {
            $this->quality += 1;
        }

        if ($this->quality > 50) {
            $this->quality = 50;
        }
    }

}
