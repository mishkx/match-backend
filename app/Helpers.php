<?php

namespace App;

use DB;
use Closure;

class Helpers
{
    public static function applySqlQueryBindings(string $query, array $bindings)
    {
        return array_reduce($bindings, function ($sql, $binding) {
            return preg_replace('/\?/', is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1);
        }, $query);
    }

    public static function dumpQueryLog(Closure $callback)
    {
        DB::enableQueryLog();
        call_user_func($callback);
        dump(self::getQueryLog());
        DB::disableQueryLog();
    }

    public static function getQueryLog()
    {
        return collect(DB::getQueryLog())
            ->map(function ($item) {
                return [
                    'sql' => self::applySqlQueryBindings($item['query'], $item['bindings']),
                    'time' => $item['time'],
                ];
            })
            ->toArray();
    }
}
