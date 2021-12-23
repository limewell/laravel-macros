<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

if (!Blueprint::hasMacro('withWhereHas')) {
    Blueprint::macro('hasForeign', function (string $foreignKey): bool {
        $schema = DB::connection()->getDatabaseName();
        return !empty(
            DB::select(
                DB::raw(
                    "SELECT * FROM information_schema.TABLE_CONSTRAINTS
                        WHERE information_schema.TABLE_CONSTRAINTS.CONSTRAINT_TYPE = 'FOREIGN KEY'
                        AND information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA = '{$schema}'
                        AND information_schema.TABLE_CONSTRAINTS.TABLE_NAME = '{$this->table}'
                        AND information_schema.TABLE_CONSTRAINTS.CONSTRAINT_NAME = '{$foreignKey}';"
                )
            )
        );
    });
}
