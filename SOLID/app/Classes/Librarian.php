<?php

namespace App\Classes;
use App\Interfaces\LibrarianInterface;
use App\Interfaces\RentalInterface;
use App\Models\Item;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;

class Librarian extends Patron implements LibrarianInterface
{

    public function calculateDate():string{
        return Carbon::now()->addDays(14)->format('d.m.Y');
    }

    public function comment(): string
    {
        return 'From Library';
    }

    public function add(array $data):Item
    {
        return Item::create($data);
    }

    public function block(User $user)
    {
        $user->update(['status'=>'Blocked']);
    }

    public function unblock(User $user)
    {
        $user->update(['status'=>'Active']);
    }

}
