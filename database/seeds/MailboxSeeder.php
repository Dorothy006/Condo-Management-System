<?php

use Illuminate\Database\Seeder;
use App\Mailbox;

class MailboxSeeder extends Seeder
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
            $mailbox=['available' => 0];
            Mailbox::create($mailbox);
        }


    }
}
