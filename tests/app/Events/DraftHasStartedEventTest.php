<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DraftHasStartedEventTest extends TestCase
{
    /**
     * @test
     */
    public function handle()
    {
        $this->assertTrue(true);
    }
}