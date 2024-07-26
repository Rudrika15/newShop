<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PincodeSeeder extends Seeder
{
    public function run()
    {
        // Assuming your JSON file is named "pincodes.json" and located in the "public" folder
        $jsonPath = public_path('pincode_IN.json');
        $json = File::get($jsonPath);
        $pincodesData = json_decode($json, true);

        foreach ($pincodesData as $state => $districts) {
            foreach ($districts as $district => $cities) {
                foreach ($cities as $city => $pincode) {
                    DB::table('pincodes')->insert([
                        'state' => $state,
                        'district' => $district,
                        'city' => $city,
                        'pincode' => trim($pincode),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
