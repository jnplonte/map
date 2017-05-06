<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MapTest extends TestCase
{
    //testing getting route
    public function testGetRoute()
    {
      $this->json('GET', '/route/832219bfa054d5a9257dfc1470dced6d')
            ->seeJsonStructure([
                 'status',
                 'path',
                 'total_distance',
                 'total_time'
             ]);
    }

    // testing adding route
    public function testAddRoute()
    {
      $this->json('POST', '/route', ['param' => '[["22.3061093","114.1716293"],["22.3013212","114.1704476"],["22.304309","114.171990"]]'])
            ->seeJsonStructure([
                'status',
                'token'
             ]);
      $this->seeInDatabase('geocode', ['lat' => '22.3061093', 'lng' => '114.1716293']);
    }
}
