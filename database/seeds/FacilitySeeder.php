<?php

use Illuminate\Database\Seeder;
use App\Facilities;
use \Illuminate\Support\Facades\DB;
class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facility =array(['facility_name'=>'Pool Room','duration'=>2,'fee'=>20, 'facility_desc'=>'Pool Room is limited to 8 people'],
                        ['facility_name'=>'Bowling','duration'=>3,'fee'=>10, 'facility_desc'=>'Bowling room is limited to 10 people'],
                        ['facility_name'=>'Conference Room','duration'=>2,'fee'=>20, 'facility_desc'=>'Conference has a capacity of 20 people']);
        DB::table('facilities')->insert($facility);
//        \Illuminate\Support\Facades\DB::table('facilities')->insert($facility);
    }
}
