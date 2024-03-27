<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Books
            [
                'name' => 'The Lord of the Rings',
                'category' => 'Books',
                'stock' => 5,
            ],
            [
                'name' => 'Pride and Prejudice',
                'category' => 'Books',
                'stock' => 3,
            ],
            [
                'name' => 'To Kill a Mockingbird',
                'category' => 'Books',
                'stock' => 2,
            ],

            // CDs
            [
                'name' => 'Abbey Road - The Beatles',
                'category' => 'CDs',
                'stock' => 4,
            ],
            [
                'name' => 'Kind of Blue - Miles Davis',
                'category' => 'CDs',
                'stock' => 1,
            ],
            [
                'name' => 'The Wall - Pink Floyd',
                'category' => 'CDs',
                'stock' => 3,
            ],

            // Magazines
            [
                'name' => 'National Geographic',
                'category' => 'Magazines',
                'stock' => 10,
            ],
            [
                'name' => 'The New Yorker',
                'category' => 'Magazines',
                'stock' => 8,
            ],
            [
                'name' => 'Vogue',
                'category' => 'Magazines',
                'stock' => 5,
            ],
        ];

        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
}
