<?php

namespace App\Traits;

use Cache;
use Illuminate\Database\Eloquent\Model;

trait FillableTrait
{
    protected function setFillable()
    {
        if ($this instanceof Model) {
            $key = get_called_class() . ':Fillable';
            $ttl = now()->addMinutes(config('options.cache.time'));

            $this->fillable = Cache::remember($key, $ttl, function () {
                return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
            });
        }
    }
}
