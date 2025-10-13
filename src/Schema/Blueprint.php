<?php

namespace Grimzy\LaravelMysqlSpatial\Schema;

use Illuminate\Database\Schema\Blueprint as IlluminateBlueprint;

class Blueprint extends IlluminateBlueprint
{
    /**
     * Add a geometry column on the table.
     *
     * @param string   $column
     * @param string|null $subtype
     * @param int      $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function geometry($column, $subtype = null, $srid = 0)
    {
        return $this->addColumn('geometry', $column, compact('subtype', 'srid'));
    }

    /**
     * Add a point column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function point($column, $srid = null)
    {
        return $this->addColumn('point', $column, compact('srid'));
    }

    /**
     * Add a linestring column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function linestring($column, $srid = null)
    {
        return $this->addColumn('linestring', $column, compact('srid'));
    }

    /**
     * Add a polygon column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function polygon($column, $srid = null)
    {
        return $this->addColumn('polygon', $column, compact('srid'));
    }

    /**
     * Add a multipoint column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function multipoint($column, $srid = null)
    {
        return $this->addColumn('multipoint', $column, compact('srid'));
    }

    /**
     * Add a multilinestring column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function multilinestring($column, $srid = null)
    {
        return $this->addColumn('multilinestring', $column, compact('srid'));
    }

    /**
     * Add a multipolygon column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function multipolygon($column, $srid = null)
    {
        return $this->addColumn('multipolygon', $column, compact('srid'));
    }

    /**
     * Add a geometrycollection column on the table.
     *
     * @param string   $column
     * @param null|int $srid
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function geometrycollection($column, $srid = null)
    {
        return $this->addColumn('geometrycollection', $column, compact('srid'));
    }
}