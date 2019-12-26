<?php

namespace App\Traits;

use Faker\Factory as Faker;

trait FakerTrait
{
    private $faker;

    protected function faker()
    {
        if (!$this->faker) {
            $this->faker = Faker::create(config('app.faker_locale'));
        }
        return $this->faker;
    }
}
