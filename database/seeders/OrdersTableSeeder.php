<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::truncate();

        Order::create([
            'created_by_id' => 1,
            'status' => 'Completed',
            'description' => 'The site of Toronto lay at the entrance to one of the oldest routes to the northwest, a route known and used by the Huron, Iroquois, and Ojibwe, and was of strategic importance from the beginning of Ontario\'s recorded history.',
            'phone' => '0312 612 459',
        ]);

        Order::create([
            'status' => 'Awaiting Pickup',
            'description' => 'Old Toronto is also home to many historically wealthy residential enclaves, such as Yorkville, Rosedale, The Annex, Forest Hill, Lawrence Park, Lytton Park, Deer Park, Moore Park, and Casa Loma, most stretching away from downtown to the north.',
        ]);

        Order::create([
            'created_by_id' => 2,
            'status' => 'Shipped',
            'description' => 'Just deliver in time. Don\'t piss me off',
            'phone' => '0378 612 723',
        ]);

        Order::create([
            'created_by_id' => 1,
            'status' => 'Cancelled',
            'phone' => '+7-923-120-00-09',
        ]);

        Order::create([
            'created_by_id' => 2,
            'status' => 'Order Confirmed',
            'description' => 'Toronto experiences an average of 2,066 sunshine hours or 45 percent of daylight hours, varying between a low of 28 percent in December to 60% in July.',
            'phone' => '0312 612 459',
        ]);

        Order::create([
            'created_by_id' => 2,
            'status' => 'Awaiting Confirmation',
            'description' => 'A present for my beloved granny. Hope she likes this stuff. If not - I\'m going to return it',
            'phone' => '0312 612 459',
        ]);

        Order::create([
            'status' => 'Awaiting Confirmation',
            'description' => 'The city\'s foreign-born persons made up 47 per cent of the population, compared to 49.9 per cent in 2006. According to the United Nations Development Programme, Toronto has the second-highest percentage of constant foreign-born population among world cities, after Miami, Florida.',
            'phone' => '+7-956-678-00-90',
        ]);

        $this->attachItems();
    }

    public function attachItems(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            // excluding Product #24 for using it in tests for the case there Product doesn't have any Orders
            $products = Product::inRandomOrder()->whereNotIn('id', [24])->take(rand(1, 5))->get();

            $productData = [];
                    
            foreach ($products as $product) {
                $productData[$product->id] = [
                    'price' => $product->price,
                    'quantity' => rand(1, 5),
                ];
            }
    
            $order->products()->attach($productData);
        }
    }
}
