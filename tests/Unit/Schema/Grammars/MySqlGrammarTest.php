<?php

namespace Schema\Grammars;

use Grimzy\LaravelMysqlSpatial\MysqlConnection;
use Grimzy\LaravelMysqlSpatial\Schema\Blueprint;
use Grimzy\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar;

class MySqlGrammarTest extends \BaseTestCase
{
    public function testAddingGeometry()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->geometry('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` GEOMETRY not null', $statements[0]);
    }

    public function testAddingPoint()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->point('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` POINT not null', $statements[0]);
    }

    public function testAddingLinestring()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->linestring('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` LINESTRING not null', $statements[0]);
    }

    public function testAddingPolygon()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->polygon('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` POLYGON not null', $statements[0]);
    }

    public function testAddingMultipoint()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->multipoint('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` MULTIPOINT not null', $statements[0]);
    }

    public function testAddingMultiLinestring()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->multilinestring('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` MULTILINESTRING not null', $statements[0]);
    }

    public function testAddingMultiPolygon()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->multipolygon('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` MULTIPOLYGON not null', $statements[0]);
    }

    public function testAddingGeometryCollection()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->geometrycollection('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` GEOMETRYCOLLECTION not null', $statements[0]);
    }

    public function testAddingGeometryWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->geometry('foo', null, 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` GEOMETRY not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingPointWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->point('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` POINT not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingLinestringWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->linestring('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` LINESTRING not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingPolygonWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->polygon('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` POLYGON not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingMultipointWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->multipoint('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` MULTIPOINT not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingMultiLinestringWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->multilinestring('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` MULTILINESTRING not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingMultiPolygonWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->multipolygon('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` MULTIPOLYGON not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddingGeometryCollectionWithSrid()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->geometrycollection('foo', 4326);
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
        $this->assertEquals('alter table `test` add `foo` GEOMETRYCOLLECTION not null /*!80003 SRID 4326 */', $statements[0]);
    }

    public function testAddRemoveSpatialIndex()
    {
        $blueprint = new Blueprint($this->getConnection(), 'test');
        $blueprint->point('foo');
        $blueprint->spatialIndex('foo');
        $addStatements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(2, count($addStatements));
        $this->assertEquals('alter table `test` add spatial index `test_foo_spatialindex`(`foo`)', $addStatements[1]);

        $blueprint->dropSpatialIndex(['foo']);
        $blueprint->dropSpatialIndex('test_foo_spatialindex');
        $dropStatements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $expectedSql = 'alter table `test` drop index `test_foo_spatialindex`';
        $this->assertEquals(4, count($dropStatements));
        $this->assertEquals($expectedSql, $dropStatements[2]);
        $this->assertEquals($expectedSql, $dropStatements[3]);
    }

    /**
     * @return (\Mockery\MockInterface&object&\Mockery\LegacyMockInterface)|MysqlConnection|(MysqlConnection&\Mockery\MockInterface&object&\Mockery\LegacyMockInterface)
     */
    protected function getConnection()
    {
        $connection = \Mockery::mock(MysqlConnection::class);
        $connection->shouldReceive('getTablePrefix')
            ->andReturn('');
        $connection->shouldReceive('getConfig')
            ->andReturn([]);

        $grammar = new MySqlGrammar($connection);
        $connection->shouldReceive('getSchemaGrammar')
            ->andReturn($grammar);

        return $connection;
    }

    protected function getGrammar()
    {
        $connection = \Mockery::mock(MysqlConnection::class);
        $connection->shouldReceive('getTablePrefix')
            ->andReturn('');
        return new MySqlGrammar($connection);
    }
}
