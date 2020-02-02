<?php

namespace App\Contracts\Presenters;

interface PresenterContract
{
    public function __toString(): string;

    public function __construct($resource);

    public function setResource($resource): self;

    public static function boolean($value): bool;

    public static function integer($value): int;

    public static function string($value): string;

    public static function collection($value): array;

    public static function assoc($value = []);

    public static function dateTime($value, $format = ''): string;

    public static function nullableInteger($value): ?int;

    public static function nullableString($value): ?string;

    public static function nullableCollection($value): ?array;

    public static function nullableAssoc($value);

    public static function nullableDateTime($value, $format = ''): ?string;
}
