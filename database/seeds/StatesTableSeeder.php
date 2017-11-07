<?php

use Illuminate\Database\Seeder;
use App\MrtModels\States;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        States::create([
            'country_id' => '13',
            'name' => 'ACT'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'NT'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'WA'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'NSW'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'VIC'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'QLD'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'SA'
        ]);
        States::create([
            'country_id' => 13,
            'name' => 'TAS'
        ]);
    }
}
