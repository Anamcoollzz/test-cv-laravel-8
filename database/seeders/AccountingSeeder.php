<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Income;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $faker = Factory::create('id_ID');
        Income::truncate();
        foreach (range(1, 500) as $i) {
            $price = $faker->numberBetween(1, 10);
            $qty   = $faker->numberBetween(1, 20);
            $date  = $faker->dateTimeBetween('2021-01-01', '2021-12-31');
            $row = [
                'product_name'  => 'Product ' . $i,
                'product_price' => $price,
                'qty'           => $qty,
                'price_total'   => $price * $qty,
                'product_image' => 'hehe',
                'buyer_name'    => $faker->name,
                'buyer_address' => $faker->address,
                'created_at'    => $date,
                'updated_at'    => $date,
            ];
            array_push($data, $row);
        }
        Income::insert($data);

        $data = [];

        Expense::truncate();
        foreach (range(1, 500) as $i) {
            $price = $faker->numberBetween(1, 10);
            $qty = $faker->numberBetween(1, 20);
            $qty   = $faker->numberBetween(1, 20);
            $date  = $faker->dateTimeBetween('2021-01-01', '2021-12-31');
            $row = [
                'product_name'  => 'Product ' . $i,
                'product_price' => $price,
                'qty'           => $qty,
                'price_total'   => $price * $qty,
                'product_image' => 'hehe',
                'buyer_name'    => $faker->name,
                'buyer_address' => $faker->address,
                'created_at'    => $date,
                'updated_at'    => $date,
            ];
            array_push($data, $row);
        }
        Expense::insert($data);
    }
}
