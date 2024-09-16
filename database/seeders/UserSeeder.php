<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email' ,"admin@gmail.com" )->first()) {

            DB::table('users')->insert([
                'lastname'      => "Admin",
                'firstname'     => "Admin",
                'email'         => "admin@gmail.com",
                'status'        => 'super_admin',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);

        }

        if (!User::where('email' ,"gestproduct@gmail.com" )->first()) {

            DB::table('users')->insert([
                'lastname'      => "Gestionnaire",
                'firstname'     => "Produit",
                'email'         => "gestproduct@gmail.com",
                'status'        => 'product_manager',
                'sites_id'      => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);

        }

        if (!User::where('email' ,"geststock@gmail.com" )->first()) {

            DB::table('users')->insert([
                'lastname'      => "Gestionnaire",
                'firstname'     => "Stock",
                'email'         => "geststock@gmail.com",
                'status'        => 'stock_manager',
                'sites_id'      => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);

        }
    }
}
