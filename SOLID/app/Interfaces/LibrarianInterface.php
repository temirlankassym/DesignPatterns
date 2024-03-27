<?php

namespace App\Interfaces;

use App\Models\Item;
use App\Models\User;

interface LibrarianInterface{
    public function add(array $data):Item;
    public function block(User $user);
    public function unblock(User $user);
}
