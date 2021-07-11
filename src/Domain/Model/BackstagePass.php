<?php

namespace Runroom\GildedRose\Domain\Model;

class BackstagePass extends Item {
    
    public function updateQuality(): void {
        $this->sellIn -= 1;

        if ($this->sellIn < 0) {
            $this->quality = 0;
        } else {

            $this->quality += 1;

            if ($this->sellIn < 10) {
                $this->quality += 1;
            }

            if ($this->sellIn < 5) {
                $this->quality += 1;
            }

            if ($this->quality > 50) {
                $this->quality = 50;
            }
        }
    }

}
