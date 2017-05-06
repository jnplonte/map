<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UrlTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBaseUrl()
    {
        $this->visit('/')->see('GOOGLE MAP TEST');
    }
}
