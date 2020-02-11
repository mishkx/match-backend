<?php

namespace App;

use Closure;
use DB;
use Exception;
use File;
use Illuminate\Support\Arr;

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

    public static function asset($name)
    {
        $directory = config('options.assets.directory');
        $manifest = public_path($directory . config('options.assets.file'));

        if (!File::exists($manifest)) {
            throw new Exception('Asset manifest does not exist.');
        }

        $content = json_decode(File::get($manifest), true);

        return $directory . Arr::get($content['files'], $name);
    }
}
