<?php

namespace Corp\Repositories;

use Corp\Slider;

class SliderRepository extends Repository
{
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }
}