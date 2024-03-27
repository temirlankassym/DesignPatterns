<?php

namespace App\Http\Controllers;

use App\Classes\Librarian;
use App\Http\Requests\AddItemRequest;
use App\Models\User;

class AdminController extends Controller
{
    private Librarian $librarian;

    public function __construct(Librarian $librarian)
    {
        $this->librarian = $librarian;
    }

    public function add(AddItemRequest $request){
        $item = $this->librarian->add($request->validated());
        return response()->json([
            'Success' => $item
        ],200);
    }

    public function block(User $user){
        $this->librarian->block($user);
        return response()->json([
            'Success' => $user
        ],200);
    }

    public function unblock(User $user){
        $this->librarian->unblock($user);
        return response()->json([
            'Success' => $user
        ],200);
    }
}
