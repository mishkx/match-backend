<?php

namespace App\Base;

use App\Contracts\Presenters\PresenterContract;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Presenter implements PresenterContract
{
    protected $resource;
    protected $relations;

    protected const DATETIME_FORMAT = Carbon::DEFAULT_TO_STRING_FORMAT;
    protected const DATE_FORMAT = 'Y-m-d';

    public function __toString()
    {
        return collect($this->resource)->toJson();
    }

    protected function getResourceValue($key, $default = null)
    {
        return Arr::get($this->resource, $key, $default);
    }

    protected function getRelationPresenter($relation, $presenterClass)
    {
        if (!Arr::has($this->relations, $relation)) {
            $this->relations[$relation] = new $presenterClass($this->getResourceValue($relation));
        }
        return $this->relations[$relation];
    }

    public static function boolean($value)
    {
        return (boolean)$value;
    }

    public static function integer($value)
    {
        return (integer)$value;
    }

    public static function string($value)
    {
        return (string)$value;
    }

    public static function array($value)
    {
        return Arr::accessible($value) ? collect($value)->values()->toArray() : [];
    }

    public static function object($value = [])
    {
        return Arr::isAssoc($value) ? $value : new \stdClass();
    }

    public static function dateTime($value, $format = self::DATETIME_FORMAT)
    {
        if ($value instanceof Carbon) {
            return $value->format($format);
        }
        return Carbon::parse($value)->format($format);
    }

    public static function nullableInteger($value)
    {
        return is_null($value) ? $value : self::integer($value);
    }

    public static function nullableString($value)
    {
        return is_null($value) ? $value : self::string($value);
    }

    public static function nullableArray($value)
    {
        return is_null($value) ? $value : self::array($value);
    }

    public static function nullableObject($value)
    {
        return is_null($value) ? $value : self::object($value);
    }

    public static function nullableDateTime($value, $format = self::DATETIME_FORMAT)
    {
        return is_null($value) ? $value : self::dateTime($value, $format);
    }
}
