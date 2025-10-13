<?php

namespace Grimzy\LaravelMysqlSpatial;

use Doctrine\DBAL\Types\Type as DoctrineType;
use Grimzy\LaravelMysqlSpatial\Connectors\ConnectionFactory;
use Grimzy\LaravelMysqlSpatial\Doctrine\Geometry;
use Grimzy\LaravelMysqlSpatial\Doctrine\GeometryCollection;
use Grimzy\LaravelMysqlSpatial\Doctrine\LineString;
use Grimzy\LaravelMysqlSpatial\Doctrine\MultiLineString;
use Grimzy\LaravelMysqlSpatial\Doctrine\MultiPoint;
use Grimzy\LaravelMysqlSpatial\Doctrine\MultiPolygon;
use Grimzy\LaravelMysqlSpatial\Doctrine\Point;
use Grimzy\LaravelMysqlSpatial\Doctrine\Polygon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class DatabaseServiceProvider.
 */
class SpatialServiceProvider extends DatabaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Unbind existing database services if they exist
        if ($this->app->bound('db.factory')) {
            $this->app->offsetUnset('db.factory');
        }
        if ($this->app->bound('db')) {
            $this->app->offsetUnset('db');
        }

        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        // Register all spatial column type macros on Blueprint
        // Note: Laravel 11 has a built-in geometry() method, so this macro won't be used
        // We keep it here for documentation purposes
        Blueprint::macro('geometry', function (string $column, $subtype = null, $srid = 0) {
            /** @var Blueprint $this */
            return $this->addColumn('geometry', $column, compact('subtype', 'srid'));
        });

        Blueprint::macro('point', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('point', $column, compact('srid'));
        });

        Blueprint::macro('lineString', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('linestring', $column, compact('srid'));
        });

        Blueprint::macro('polygon', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('polygon', $column, compact('srid'));
        });

        Blueprint::macro('multiPoint', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('multipoint', $column, compact('srid'));
        });

        Blueprint::macro('multiLineString', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('multilinestring', $column, compact('srid'));
        });

        Blueprint::macro('multiPolygon', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('multipolygon', $column, compact('srid'));
        });

        Blueprint::macro('geometryCollection', function (string $column, $srid = null) {
            /** @var Blueprint $this */
            return $this->addColumn('geometrycollection', $column, compact('srid'));
        });

        // Register Grammar type methods as macros
        $mysqlGrammarClass = \Illuminate\Database\Schema\Grammars\MySqlGrammar::class;
        
        $mysqlGrammarClass::macro('typeGeometry', function (\Illuminate\Support\Fluent $column) {
            $type = 'GEOMETRY';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typePoint', function (\Illuminate\Support\Fluent $column) {
            $type = 'POINT';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typeLinestring', function (\Illuminate\Support\Fluent $column) {
            $type = 'LINESTRING';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typePolygon', function (\Illuminate\Support\Fluent $column) {
            $type = 'POLYGON';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typeMultipoint', function (\Illuminate\Support\Fluent $column) {
            $type = 'MULTIPOINT';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typeMultilinestring', function (\Illuminate\Support\Fluent $column) {
            $type = 'MULTILINESTRING';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typeMultipolygon', function (\Illuminate\Support\Fluent $column) {
            $type = 'MULTIPOLYGON';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        $mysqlGrammarClass::macro('typeGeometrycollection', function (\Illuminate\Support\Fluent $column) {
            $type = 'GEOMETRYCOLLECTION';
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                $type .= ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return $type;
        });

        // Register SRID modifier
        $mysqlGrammarClass::macro('modifySrid', function (\Illuminate\Database\Schema\Blueprint $blueprint, \Illuminate\Support\Fluent $column) {
            if (!is_null($column->srid) && is_int($column->srid) && $column->srid > 0) {
                return ' /*!80003 SRID ' . $column->srid . ' */';
            }
            return '';
        });

        Blueprint::macro('microPoint', function (string $column, int $srid = 4326) {
            /** @var Blueprint $this */
            return $this->addColumn('point', $column, compact('srid'));
        });
        
        Blueprint::macro('dropMicroPoint', function (string $column) {
            /** @var Blueprint $this */
            return $this->dropColumn($column);
        });
    }
}
