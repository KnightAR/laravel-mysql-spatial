<?php

namespace Grimzy\LaravelMysqlSpatial\Eloquent;

use Grimzy\LaravelMysqlSpatial\Types\GeometryInterface;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Grammar;

/**
 * @property GeometryInterface $value
 */
class SpatialExpression extends Expression
{
    public function getValue(Grammar $grammar)
    {
        return "ST_GeomFromText(?, ?)";
    }

    /**
     * @return string
     */
    public function getSpatialValue()
    {
        return $this->value->toWkt();
    }

    /**
     * @return int
     */
    public function getSrid()
    {
        return $this->value->getSrid();
    }
}
