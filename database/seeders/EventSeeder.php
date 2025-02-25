<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Event\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = [
            [
                'name' => 'HRS',
                'discipline_id' => 1,
                'start_date' => '2024-02-14',
                'end_date' => '2024-02-15',
                'country_id' => 151,
                'place' => 'Rabat agdal',
                'organizer_id' => 1,
            ],
            [
                'name' => 'BLACKBALL ChAMPIONNAT DU MAROC',
                'discipline_id' => 2,
                'start_date' => '2024-02-14',
                'end_date' => '2024-02-15',
                'country_id' => 151,
                'place' => 'Fcafé',
                'organizer_id' => 1,
            ],
        ];
        foreach($events as $event){
            Event::create($event);
        }
    }
}
