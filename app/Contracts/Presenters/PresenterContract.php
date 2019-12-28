<?php

namespace App\Contracts\Presenters;

interface PresenterContract
{
    public function __toString();

    public static function boolean($value);

    public static function integer($value);

    public static function string($value);

    public static function array($value);

    public static function object($value = []);

    public static function dateTime($value, $format = '');

    public static function nullableInteger($value);

    public static function nullableString($value);

    public static function nullableArray($value);

    public static function nullableObject($value);

    public static function nullableDateTime($value, $format = '');
}
