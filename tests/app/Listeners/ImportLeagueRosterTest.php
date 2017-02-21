<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ImportLeagueRosterTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @test
     */
    public function handle()
    {
        $gameMock = new \App\Game(['id' => 1, 'game_id' => 111,'name' => 'Test', 'season' => 2000, 'code' => 'tst' ]);
        $gameMock->save();

        $userMock = new \App\User();
        $leagueMock = new \App\League(['id' => 1, 'league_id' => 111, 'game_id' => 1]);
        $leagueMock->save();

        $dtoMock = Mockery::mock(\App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto::class);
        $dtoMock->shouldReceive('toArray')->andReturn(['league_id' => 111, 'game_id' => 111]);

        $settingsResponseDto = Mockery::mock(\App\Yahoo\Responses\Leagues\SettingsResponse::class);
        $settingsResponseDto->shouldReceive('simpleResponse')->andReturn(
            new \Illuminate\Support\Collection(
                [['name' => 'league Name', 'draft_status' => 'predraft', 'roster_positions' => [
                    ['roster_position'=> ['count' => 1, 'position' => 'QB']
                    ],
                    ['roster_position'=> ['count' => 5, 'position' => 'BN']
                    ],
                ]]])
        );

        $serviceMock = Mockery::mock(\App\Yahoo\Services\Fantasy\Leagues\GetSettings::class);
        $serviceMock->shouldReceive('call')->andReturn($settingsResponseDto);
        $serviceMock->shouldReceive('setUser');
        $serviceMock->shouldReceive('setUriParams');


        $eventMock = Mockery::mock(\App\Events\UserLeaguesImported::class);
        $eventMock->user = $userMock;
        $eventMock->league = $leagueMock;
        $eventMock->dto = $dtoMock;

        $listener = new \App\Listeners\ImportLeagueRoster($serviceMock);

        $listener->handle($eventMock);

        $this->assertDatabaseHas('leagues', [
            'name' => 'league Name'
        ]);

        $this->assertDatabaseHas('rosters', [
            'position' => 'QB',
            'league_id' => $leagueMock->id,
            'count' => 1
        ]);

        $this->assertDatabaseHas('rosters', [
            'position' => 'BN',
            'league_id' => $leagueMock->id,
            'count' => 5
        ]);

        $this->getDispatched();
    }



}