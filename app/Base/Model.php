<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use Fillable;

    public function __construct(array $attributes = [])
    {
        $this->setFillable();
        parent::__construct($attributes);
    }
}
