<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Location\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonPath = storage_path('app/public/countries.json');
        $jsonData = file_get_contents($jsonPath);
        $dataArray = json_decode($jsonData, true);
        foreach ($dataArray as $data) {
            Country::create([
                'name' => $data['name'],
                'iso2' => $data['iso2'],
                'iso3' => $data['iso3'],
            ]);
        }

    }
}
