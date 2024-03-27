<?php

namespace App\Classes;
use App\Interfaces\RentalInterface;
use App\Models\Item;
use App\Models\Rental;
use App\Services\RentalService;
use Carbon\Carbon;

class Patron implements RentalInterface
{
    public function calculateDate():string{
        return Carbon::now()->addDays(7)->format('d.m.Y');
    }

    public function comment():string{
        return 'I am a Reader';
    }

    public function rent(array $data): Item
    {
        $item = Item::where('name',$data['item_name'])->first();

        Rental::create([
            'username'=>$data['username'],
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'start_date' => date('d.m.Y'),
            'end_date' => $data['user']->calculateDate(), // Liskov Substitution
            'comment' => $data['user']->comment()
        ]);

        return $item;
    }

    public function stockDecrement(Item $item){
        $item->decrement('stock');
    }
}
