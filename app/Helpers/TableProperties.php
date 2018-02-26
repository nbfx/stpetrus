<?php

namespace App\Helpers;


trait TableProperties
{
    /**
     * @return array
     */
    public function getTableColumns():array
    {
        $table = $this->getTable();
        $schemaBuilder = $this->getConnection()->getSchemaBuilder();
        $columnsNames = $schemaBuilder->getColumnListing($table);
        foreach ($columnsNames as $columnName) {
            $columns[$columnName] = $schemaBuilder->getColumnType($table, $columnName);
        }

        return $columns ?? [];
    }
}