<?php

use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            \Illuminate\Support\Facades\DB::table('rooms')
                ->insert(['name' => 'room_' . $i]);
        }
    }
}