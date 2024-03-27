<?php

namespace App\Http\Controllers;

use App\Classes\Patron;
use App\Http\Requests\RentItemRequest;
use App\Interfaces\RentalInterface;
use App\Services\RentalService;

class RentalController extends Controller
{
    private RentalService $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    public function rent(RentItemRequest $request)
    {
        $data = $request->validated();
        $item_name = $data['name'];
        $username = $data['username'] ?? auth()->user()->first_name;

        $this->rentalService->rent($item_name, $username, $this->getPermissionLevel());

        return response()->json([
            'Success'
        ],200);
    }

    // Open-Closed
    public function getPermissionLevel():RentalInterface{
        $role = 'App\Classes\\'.auth()->user()->role;
        if(class_exists($role)){
            return new $role();
        }
        return new Patron();
    }
}
