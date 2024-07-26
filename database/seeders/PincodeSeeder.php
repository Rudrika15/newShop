<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PincodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = public_path('pincodes_IN.json');
        $json = File::get($jsonPath);
        $pincodes = json_decode($json, true);

        foreach ($pincodes as $pincode) {
            DB::table('pincodes')->insert([
                'pincode' => $pincode['pincode'],
                'area' => $pincode['area'],
                'city' => $pincode['city'],
                'state' => $pincode['state'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}
