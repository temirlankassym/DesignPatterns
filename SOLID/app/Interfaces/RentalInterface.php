<?php

namespace App\Interfaces;

use App\Models\Item;

// Interface Segregation
interface RentalInterface{
    public function calculateDate():string;
    public function comment():string;
    public function rent(array $data):Item;
    public function stockDecrement(Item $item);
}
