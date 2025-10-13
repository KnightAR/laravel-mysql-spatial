<?php

namespace Schema;

use BaseTestCase;
use Grimzy\LaravelMysqlSpatial\MysqlConnection;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Grimzy\LaravelMysqlSpatial\Schema\Builder;
use Mockery;

class BuilderTest extends BaseTestCase
{
    public function testReturnsCorrectBlueprint()
    {
        $grammar = Mockery::mock(\Grimzy\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar::class);

        $connection = Mockery::mock(MysqlConnection::class);
        $connection->shouldReceive('getSchemaGrammar')->andReturn($grammar);

        $mock = Mockery::mock(Builder::class, [$connection]);
        $mock->makePartial()->shouldAllowMockingProtectedMethods();
        $blueprint = $mock->createBlueprint('test', function () {
        });

        $this->assertInstanceOf(Blueprint::class, $blueprint);
    }
}
