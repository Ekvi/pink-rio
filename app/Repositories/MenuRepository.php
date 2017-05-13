<?php

namespace Corp\Repositories;

use Corp\Menu;

class MenuRepository extends Repository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }
}