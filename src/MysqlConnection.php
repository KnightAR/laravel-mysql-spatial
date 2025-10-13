<?php

namespace Grimzy\LaravelMysqlSpatial;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type as DoctrineType;
use Grimzy\LaravelMysqlSpatial\Schema\Builder;
use Grimzy\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar;
use Illuminate\Database\MySqlConnection as IlluminateMySqlConnection;

class MysqlConnection extends IlluminateMySqlConnection
{
    /**
     * Get the default schema grammar instance.
     *
     * @return MysqlConnection
     */
    protected function getDefaultSchemaGrammar()
    {
        $grammar = new MySqlGrammar($this);
        return $this->setSchemaGrammar($grammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new Builder($this);
    }
}