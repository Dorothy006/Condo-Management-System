<?php

use Illuminate\Database\Seeder;
use App\Rooms;
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
		for($i = 0; $i < 10; $i++){
    		$room=['roomnumber'=>'00'.$i,'size'=>rand(100,500),'status'=>0];
    		Rooms::create($room);
		}
    }
}
