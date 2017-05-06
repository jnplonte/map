<?php

use Illuminate\Database\Seeder;

class distance_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('distance')->insert([[
          'id' => '1',
          'token' => '861e8535ce35755bee1d66d53d2a86cd',
          'start_id' => '1',
          'end_ids' => '2,3',
          'updated_at' =>  date('Y-m-d G:i:s'),
          'created_at' =>  date('Y-m-d G:i:s')
      ],
      [
          'id' => '2',
          'token' => '832219bfa054d5a9257dfc1470dced6d',
          'start_id' => '2',
          'end_ids' => '3',
          'updated_at' =>  date('Y-m-d G:i:s'),
          'created_at' =>  date('Y-m-d G:i:s')
      ]]);
    }
}
