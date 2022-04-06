<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

if (!Collection::hasMacro('loadWithLimit')) {
    Collection::macro('loadWithLimit', function ($relations): Collection {
        $collection = $this;
        $relations = is_string($relations) ? func_get_args() : $relations;
        foreach ($relations as $name => $constraints) {
            if (is_int($name)) {
                $name = $constraints;
                if (Str::contains($name, ':')) {
                    $name = explode(':', 'name', 2)[0];
                    $constraints = function (Relation $query) use ($name) {
                        $query->select(explode(',', explode(':', $name, 3)[1]));
                    };
                } else {
                    $constraints = function () {
                    };
                }
            }

            /** @var Relation $relation */
            $relation = $collection
                ->map(function (Model $model) use ($name) {
                    return $model->{$name}();
                })
                ->each(function (Relation $relation) use ($constraints) {
                    $constraints($relation);
                })
                ->reduce(function (?Relation $carry, Relation $query) {
                    return $carry ? $carry->unionAll($query) : $query;
                });

            $relation->match(
                $relation->initRelation($collection->all(), $name),
                $relation->get(), $name
            );
        }
        return $collection;
    });
}
