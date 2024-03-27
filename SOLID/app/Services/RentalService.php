<?php

namespace App\Services;

use App\Classes\Patron;
use App\Interfaces\RentalInterface;

class RentalService{
    private Patron $patron;

    public function __construct(Patron $patron)
    {
        $this->patron = $patron;
    }

    // Dependency Inversion
    public function rent(string $item_name, string $username, RentalInterface $user){
        $item = $this->patron->rent(['username'=>$username,'item_name'=>$item_name,'user'=>$user]);
        $this->patron->stockDecrement($item);
    }

}
