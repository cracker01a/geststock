<?php

namespace Database\Seeders;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Site::where('name' ,"COTONOU" )->first()) {

            DB::table('sites')->insert([
                'name'          => "COTONOU",
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);

        }
    }
}
