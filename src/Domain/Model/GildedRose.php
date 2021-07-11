<?php

namespace Runroom\GildedRose\Domain\Model;

class GildedRose {

    private $items;

    public function __construct(array $items) {
        $this->items = $items;
    }

    public function updateQuality(): void {
        foreach ($this->items as $item) {
            $item->updateQuality();
        }
    }
}
