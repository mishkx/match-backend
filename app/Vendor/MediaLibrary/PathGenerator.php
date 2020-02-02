<?php

namespace App\Vendor\MediaLibrary;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator as BasePathGenerator;

class PathGenerator implements BasePathGenerator
{
    public function getPath(Media $media): string
    {
        //todo: другой алгоритм для директории
        return Str::substr(md5($media->getKey()), 0, 3) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'c/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'cri/';
    }
}
