<?php

namespace App\Base;

use App\Traits\FillableTrait;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use FillableTrait;

    public function __construct(array $attributes = [])
    {
        $this->setFillable();
        parent::__construct($attributes);
    }
}
