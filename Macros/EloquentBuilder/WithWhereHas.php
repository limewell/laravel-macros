<?php

use Illuminate\Database\Eloquent\Builder;

if (!Builder::hasGlobalMacro('withWhereHas')) {
    Builder::macro('withWhereHas', function (string $relation, Closure $callback = null): Builder {
        return is_null($callback)
            ? $this->whereHas($relation)->with([$relation])
            : $this->whereHas($relation, $callback)->with([$relation => $callback]);
    });
}
