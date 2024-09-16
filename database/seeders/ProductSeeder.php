<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Site;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = [
            ["PC HP" , "200000"],
            ["CANET" , "4000"]
        ];


        foreach ($products as $key => $product) {
            if (!Product::where('name' , $product[0] )->first()) {

                DB::table('products')->insert([
                    'name'          => $product[0],
                    'price'         => $product[1],
                    'quantity'      => 0,
                    'isActive'      => true,
                    'sites_id'      => Site::first()->id,
                    'users_id'      => User::where('status' , 'product_manager')->first()->id,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);

            }
        }



    }
}
