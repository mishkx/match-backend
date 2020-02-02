<?php

namespace App\Base;

use App\Constants\AppConstants;
use App\Contracts\Presenters\PresenterContract;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Presenter implements PresenterContract
{
    protected $resource;
    protected $relations;

    public function __construct($resource = null)
    {
        if ($resource) {
            $this->setResource($resource);
        }
    }

    public function __toString(): string
    {
        return collect($this->resource)->toJson();
    }

    public function setResource($resource): self
    {
        $this->resource = $resource;
        return $this;
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

    public static function boolean($value): bool
    {
        return (boolean)$value;
    }

    public static function integer($value): int
    {
        return (integer)$value;
    }

    public static function string($value): string
    {
        return (string)$value;
    }

    public static function collection($value): array
    {
        return Arr::accessible($value) ? collect($value)->values()->toArray() : [];
    }

    public static function assoc($value = [])
    {
        return Arr::isAssoc($value) ? $value : new \stdClass();
    }

    public static function dateTime($value, $format = AppConstants::DATETIME_FORMAT): string
    {
        if ($value instanceof Carbon) {
            return $value->format($format);
        }
        return Carbon::parse($value)->format($format);
    }

    public static function nullableInteger($value): ?int
    {
        return is_null($value) ? $value : self::integer($value);
    }

    public static function nullableString($value): ?string
    {
        return is_null($value) ? $value : self::string($value);
    }

    public static function nullableCollection($value): ?array
    {
        return is_null($value) ? $value : self::collection($value);
    }

    public static function nullableAssoc($value)
    {
        return is_null($value) ? $value : self::assoc($value);
    }

    public static function nullableDateTime($value, $format = AppConstants::DATETIME_FORMAT): ?string
    {
        return is_null($value) ? $value : self::dateTime($value, $format);
    }
}
