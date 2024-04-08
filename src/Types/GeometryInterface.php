<?php

namespace Grimzy\LaravelMysqlSpatial\Types;

interface GeometryInterface
{
    /**
     * @return string
     */
    public function toWKT();

    /**
     * @param string $wkt
     * @param int $srid
     * @return static
     */
    public static function fromWKT($wkt, $srid = 0);

    /**
     * @return string
     */
    public function __toString();

    /**
     * @param string $wktArgument
     * @param int $srid
     * @return static
     */
    public static function fromString($wktArgument, $srid = 0);

    /**
     * @param string $geoJson
     * @return static
     */
    public static function fromJson($geoJson);
}
