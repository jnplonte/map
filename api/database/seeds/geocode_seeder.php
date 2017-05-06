<?php

use Illuminate\Database\Seeder;

class geocode_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('geocode')->insert([[
          'id' => '1',
          'lat' => '22.372081',
          'lng' => '114.107877',
          'address' => '11 Hoi Shing Rd, Tsuen Wan, Hong Kong',
          'placeid' => 'ChIJ_aA8buX4AzQRy6kkL7muCRI',
          'updated_at' =>  date('Y-m-d G:i:s'),
          'created_at' =>  date('Y-m-d G:i:s')
      ],
      [
          'id' => '2',
          'lat' => '22.326442',
          'lng' => '114.167811',
          'address' => '802 Nathan Rd, Mong Kok, Hong Kong',
          'placeid' => 'ChIJHXT1A8oABDQRGYbke8nzMEM',
          'updated_at' =>  date('Y-m-d G:i:s'),
          'created_at' =>  date('Y-m-d G:i:s')
      ],
      [
          'id' => '3',
          'lat' => '22.284419',
          'lng' => '114.159510',
          'address' => 'Laguna City, Central, Hong Kong',
          'placeid' => 'ChIJAdoqqWMABDQR7XoWJZ5at7o',
          'updated_at' =>  date('Y-m-d G:i:s'),
          'created_at' =>  date('Y-m-d G:i:s')
      ]]);
    }
}
